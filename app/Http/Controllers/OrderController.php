<?php 
namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Inventory;

use App\Models\ClinicalHistory;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function show(Order $order)
    {
        $order->load(['orderItems.item', 'orderServices', 'clinicalHistory']);
        return view('orders.show', compact('order'));
    }
    public function print(Order $order)
    {
        $order->load(['items.inventory', 'services', 'clinicalHistory']);
        return view('orders.print', compact('order'));
    }

    /*
    public function create()
    {
        $clinicalHistories = ClinicalHistory::all(); // Para seleccionar si se desea
        $items = Inventory::where('quantity', '>', 0)->get(); // Productos disponibles

        return view('orders.create', compact('clinicalHistories', 'items'));
    }*/

    public function store(Request $request)
{
    DB::beginTransaction();

    try {
        // Validación básica
        $validated = $request->validate([
            'clinical_history_id' => 'nullable|exists:clinical_histories,id',
            'services' => 'nullable|array',
            'services.*.service_name' => 'required_with:services|string',
            'services.*.price' => 'required_with:services|numeric|min:0',
            'services.*.payment_method' => 'required_with:services|string',
            'items' => 'nullable|array',
            'items.*.item_id' => 'required_with:items|exists:items,id',
            'items.*.quantity' => 'required_with:items|integer|min:1',
        ]);

        // Crear la orden principal
        $order = Order::create([
            'clinical_history_id' => $request->clinical_history_id,
        ]);

        // Agregar servicios si existen
        if ($request->has('services')) {
            foreach ($request->services as $service) {
                OrderService::create([
                    'order_id' => $order->id,
                    'service_name' => $service['service_name'],
                    'price' => $service['price'],
                    'payment_method' => $service['payment_method'],
                ]);
            }
        }

        // Agregar productos si existen
        if ($request->has('items')) {
            foreach ($request->items as $itemData) {
                $item = Item::find($itemData['item_id']);

                if ($item->stock < $itemData['quantity']) {
                    throw new \Exception("No hay suficiente stock para el producto: {$item->name}");
                }

                // Registrar el item vendido
                OrderItem::create([
                    'order_id' => $order->id,
                    'item_id' => $item->id,
                    'quantity' => $itemData['quantity'],
                ]);

                // Actualizar el stock
                $item->decrement('stock', $itemData['quantity']);
            }
        }

        DB::commit();
        return redirect()->route('orders.index')->with('success', 'Orden registrada con éxito.');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Error al registrar la orden: ' . $e->getMessage());
    }
}


}