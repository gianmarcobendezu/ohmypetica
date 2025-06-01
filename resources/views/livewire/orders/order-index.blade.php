<div class="p-4">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Listado de Órdenes') }}
        </h2>
    </x-slot>

    <a href="{{ route('orders.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded">
        Registrar
    </a>

    <div class="mt-4">
        <input type="text" wire:model.live="search"  placeholder="Buscar por mascota" class="w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" />
<!---
        <button wire:click="searchdata" class="px-4 py-2 bg-blue-500 text-white rounded">Filtrar</button>
-->
    </div>
    <div class="overflow-x-auto overflow-y-auto max-h-[500px]">
    <table class="min-w-full table-auto border-collapse bg-white shadow-md rounded-lg">
        <thead class="bg-gray-200">
            <tr class="bg-gray-100">
                <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">#</th>
                <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Mascota</th>

                <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Cliente</th>

                <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Tipo</th>
                <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Pago</th>

                <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Total</th>
                <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Fecha</th>
                <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $order)
                <tr class="hover:bg-gray-50 border-t">
                    <td class="py-3 px-4 text-sm text-gray-600">{{ $order->id }}</td>
                    <td class="py-3 px-4 text-sm text-gray-600">{{ $order->clinicalHistory->pet_name ?? 'Sin Mascota'}}</td>
                    <td class="py-3 px-4 text-sm text-gray-600">{{ $order->customer_name  }}</td>

                    <td class="py-3 px-4 text-sm text-gray-600">{{ $order->clinicalHistory->owner_name ?? 'Venta rápida' }}</td>
                    <td class="py-3 px-4 text-sm text-gray-600">{{ $order->payment_method }}</td>

                    <td class="py-3 px-4 text-sm text-gray-600">S/ {{ number_format($order->total, 2) }}</td>
                    <td class="py-3 px-4 text-sm text-gray-600">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td class="py-3 px-4 text-sm text-gray-600">
                        <a wire:click="viewOrder({{ $order->id }})" class="text-blue-500 hover:underline cursor-pointer">Ver</a>
                        <a href="{{ route('orders.print', $order->id) }}" class="text-green-500 hover:underline" target="_blank">Imprimir</a>
                        <a href="{{ route('orders.edit', $order->id) }}" class="bg-yellow-500 text-white-500 hover:underline px-3 py-1 rounded">✏️ Editar</a>

                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center py-4 text-gray-500">No hay órdenes registradas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($showModal && $selectedOrder)
<div class="fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white w-full max-w-2xl p-6 rounded shadow-lg overflow-y-auto max-h-[90vh]">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold">Detalle de Orden #{{ $selectedOrder->id }}</h2>
            <button wire:click="$set('showModal', false)" class="text-red-500 text-lg font-bold">✖</button>
        </div>

        <p><strong>Cliente:</strong> {{ $selectedOrder->customer_name }}</p>
        <p><strong>Teléfono:</strong> {{ $selectedOrder->customer_phone }}</p>
        <p><strong>Método de Pago:</strong> {{ $selectedOrder->payment_method }}</p>
        <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($selectedOrder->order_datetime)->format('d/m/Y H:i') }}</p>
        <p><strong>Observación:</strong> {{ $selectedOrder->observation }}</p>

        <hr class="my-4">

        <h3 class="text-lg font-semibold mb-2">🛠 Servicios</h3>
        <ul class="list-disc list-inside">
            @foreach ($selectedOrder->services as $service)
                <li>{{ $service->service }} — S/. {{ $service->rate }}</li>
            @endforeach
        </ul>

        <h3 class="text-lg font-semibold mt-4 mb-2">📦 Productos</h3>
        <ul class="list-disc list-inside">
            @foreach ($selectedOrder->items as $item)
                <li>{{ $item->inventory->description ?? '—' }} x {{ $item->quantity }} — S/. {{ $item->subtotal }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif

</div>