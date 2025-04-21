<div class="p-4">
    <h1 class="text-2xl font-semibold mb-4">Listado de Órdenes</h1>
    <a href="{{ route('orders.create') }}" class="bg-blue-500 rounded px-3 py-1">
        Registrar
    </a>
    <table class="min-w-full border border-gray-300 shadow-sm rounded-lg overflow-hidden">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2 border">#</th>
                <th class="px-4 py-2 border">Cliente</th>
                <th class="px-4 py-2 border">Total</th>
                <th class="px-4 py-2 border">Fecha</th>
                <th class="px-4 py-2 border">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $order)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 border text-center">{{ $order->id }}</td>
                    <td class="px-4 py-2 border">{{ $order->clinicalHistory->owner_name ?? 'Venta rápida' }}</td>
                    <td class="px-4 py-2 border text-right">S/ {{ number_format($order->total, 2) }}</td>
                    <td class="px-4 py-2 border text-center">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td class="px-4 py-2 border text-center">
                        <a href="{{ route('orders.show', $order->id) }}" class="text-blue-500 hover:underline">Ver</a> |
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