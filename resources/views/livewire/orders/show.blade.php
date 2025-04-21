<div class="p-6 max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">Detalle de Orden #{{ $order->id }}</h1>

    <div class="mb-6">
        <h2 class="text-lg font-semibold">Información del Cliente</h2>
        <p><strong>Dueño:</strong> {{ $order->clinicalHistory->owner_name ?? 'Venta rápida' }}</p>
        <p><strong>Teléfono:</strong> {{ $order->clinicalHistory->phone1 ?? 'N/A' }}</p>
        <p><strong>Fecha:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
    </div>

    <div class="mb-6">
        <h2 class="text-lg font-semibold">Servicios</h2>
        @forelse ($order->orderServices as $service)
            <div class="border-b py-2">
                <p><strong>Servicio:</strong> {{ $service->service_name }}</p>
                <p><strong>Precio:</strong> S/ {{ number_format($service->price, 2) }}</p>
                <p><strong>Método de Pago:</strong> {{ $service->payment_method }}</p>
            </div>
        @empty
            <p class="text-gray-500">No se registraron servicios.</p>
        @endforelse
    </div>

    <div class="mb-6">
        <h2 class="text-lg font-semibold">Productos</h2>
        @forelse ($order->orderItems as $item)
            <div class="border-b py-2">
                <p><strong>Producto:</strong> {{ $item->item_name }}</p>
                <p><strong>Cantidad:</strong> {{ $item->quantity }}</p>
                <p><strong>Precio Unitario:</strong> S/ {{ number_format($item->price, 2) }}</p>
                <p><strong>Total:</strong> S/ {{ number_format($item->price * $item->quantity, 2) }}</p>
            </div>
        @empty
            <p class="text-gray-500">No se registraron productos.</p>
        @endforelse
    </div>

    <div class="mt-4">
        <h2 class="text-xl font-bold">Total: S/ {{ number_format($order->total_amount, 2) }}</h2>
    </div>

    <div class="mt-6">
        <a href="{{ route('orders.print', $order->id) }}" target="_blank" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Imprimir</a>
        <a href="{{ route('sales') }}" class="ml-2 bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">Volver</a>
    </div>
</div>