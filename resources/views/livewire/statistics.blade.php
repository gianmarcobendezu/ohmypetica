<div class="p-6">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Estadística') }}
        </h2>
    </x-slot>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <div class="p-4 bg-white shadow-lg rounded-lg">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Total de Ventas del Mes</h2>
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

</div>
</div>