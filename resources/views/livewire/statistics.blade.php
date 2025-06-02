<div class="p-6">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Estadística') }}
        </h2>
    </x-slot>

    {{-- Filtro de mes --}}
    {{-- Filtro de mes --}}
    <div class="mb-6">
        <label for="selectedmonth" class="block text-gray-700 font-semibold mb-2">Selecciona el mes:</label>
        <div class="flex items-center gap-4">
            <input type="month" id="selectedmonth" wire:model.defer="selectedmonth" class="border rounded p-2 shadow">
            <button wire:click="filtrarMes" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Aplicar filtro
            </button>
        </div>
    </div> 


    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <div class="p-4 bg-white shadow-lg rounded-lg">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Total de Ventas por Servicio del Mes</h2>
            <div class="bg-blue-100 p-6 rounded-lg shadow-md">
                <h3 class="text-3xl font-bold text-blue-600">
                    {{ number_format($totalSales, 2) }}

                </h3>
            </div>
        </div>
    
        <div class="p-4 bg-white shadow-lg rounded-lg">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Total de Baños del Mes</h2>
            <div class="bg-blue-100 p-6 rounded-lg shadow-md">
                <h3 class="text-3xl font-bold text-blue-600">
                    
                    {{ number_format($totalBañoServices, 2) }}

                </h3>
            </div>
        </div>
    
        <div class="p-4 bg-white shadow-lg rounded-lg">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Total de Servicios del Mes</h2>
            <div class="bg-blue-100 p-6 rounded-lg shadow-md">
                <h3 class="text-3xl font-bold text-blue-600">
                    {{ number_format($totalServices, 2) }}

                </h3>
            </div>
        </div>
    
        <div class="p-4 bg-white shadow-lg rounded-lg">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Total de Mascotas del Mes</h2>
            <div class="bg-blue-100 p-6 rounded-lg shadow-md">
                <h3 class="text-3xl font-bold text-blue-600">
                    {{ number_format($totalMascotas, 2) }}

                </h3>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <div class="p-4 bg-white shadow-lg rounded-lg">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Total de Ordenes del Mes</h2>
            <div class="bg-blue-100 p-6 rounded-lg shadow-md">
                <h3 class="text-3xl font-bold text-blue-600">
                    {{ number_format($totalSalesOrders, 2) }}

                </h3>
            </div>
        </div>
        <div class="p-4 bg-white shadow-lg rounded-lg">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Total de Productos del Mes</h2>
            <div class="bg-blue-100 p-6 rounded-lg shadow-md">
                <h3 class="text-3xl font-bold text-blue-600">
                    {{ number_format($totalItemSales, 2) }}

                </h3>
            </div>
        </div>

       
        
    </div>

</div>
</div>