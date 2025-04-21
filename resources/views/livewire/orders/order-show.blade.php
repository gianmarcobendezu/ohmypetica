<div class="p-4">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold">Detalle de Orden #{{ $order->id }}</h2>
        <a href="{{ route('orders.index') }}" class="bg-blue-500 rounded px-3 py-1">
            ← Volver a órdenes
        </a>
    </div>

    <p><strong>Cliente:</strong> {{ $order->customer_name }}</p>
    <p><strong>Teléfono:</strong> {{ $order->customer_phone }}</p>
    <p><strong>Método de Pago:</strong> {{ $order->payment_method }}</p>
    <p><strong>Fecha:</strong> {{ $order->order_datetime }}</p>
    <p><strong>Observación:</strong> {{ $order->observation }}</p>

    <hr class="my-4">

    <h3 class="text-lg font-semibold mb-2">🛠 Servicios</h3>
    <ul class="list-disc list-inside">
        @foreach ($order->services as $service)
            <li>{{ $service->service }} — S/. {{ $service->rate }}</li>
        @endforeach
    </ul>

    <h3 class="text-lg font-semibold mt-4 mb-2">📦 Productos</h3>
    <ul class="list-disc list-inside">
        @foreach ($order->items as $item)
            <li>{{ $item->inventory->description ?? '—' }} x {{ $item->quantity }} — S/. {{ $item->subtotal }}</li>
        @endforeach
    </ul>
</div>