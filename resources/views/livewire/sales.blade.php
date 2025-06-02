<div class="p-6">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ventas') }}
        </h2>
    </x-slot>

    

    <!-- Mensaje de éxito -->
    @if (session()->has('message'))
        <div class="text-green-500 mb-4">{{ session('message') }}</div>
    @endif


    
    <!-- Tabla de servicios -->
    <div class="overflow-x-auto overflow-y-auto max-h-[500px]">

    <table class="min-w-full table-auto border-collapse bg-white shadow-md rounded-lg" >
        <thead class="bg-gray-200">
            <tr class="bg-gray-100">
                <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">ID</th>
                <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Servicio</th>
                <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Mascota</th>
                <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Fecha y Hora</th>
                <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Tarifa</th>
                <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Método de Pago</th>
                <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Observaciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sales as $sale)
                <tr class="border-t">
                    <td class="py-3 px-4 text-sm text-gray-600">{{ $sale->id }}</td>
                    <td class="py-3 px-4 text-sm text-gray-600">{{ $sale->service }}</td>
                    <td class="py-3 px-4 text-sm text-gray-600">{{ $sale->clinicalHistory->pet_name }}</td>
                    <td class="py-3 px-4 text-sm text-gray-600">{{ \Carbon\Carbon::parse($sale->service_datetime)->format('d/m/Y H:i') }}</td>
                    <td class="py-3 px-4 text-sm text-gray-600">{{ $sale->rate }}</td>
                    
                    <td class="py-3 px-4 text-sm text-gray-600">{{ $sale->payment_method }}</td>
                    <td class="py-3 px-4 text-sm text-gray-600">{{ $sale->observation }}</td>

                 
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>