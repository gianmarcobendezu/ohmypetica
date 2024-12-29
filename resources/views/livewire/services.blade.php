<div class="p-6">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestión de Servicios') }}
        </h2>
    </x-slot>

    <!-- Formulario para agregar un servicio -->
    <div class="mb-4">
        <input type="text" wire:model="name" placeholder="Nombre del servicio"
            class="px-4 py-2 border rounded-md w-full" />
        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        <button wire:click="addService" class="mt-2 px-4 py-2 bg-green-500 text-white rounded">Agregar Servicio</button>
    </div>

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
                <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Nombre del Servicio</th>
                <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($services as $service)
                <tr class="border-t">
                    <td class="py-3 px-4 text-sm text-gray-600">{{ $service->id }}</td>
                    <td class="py-3 px-4 text-sm text-gray-600">{{ $service->name }}</td>
                    <td class="py-3 px-4 text-sm text-gray-600">
                        <button wire:click="deleteService({{ $service->id }})"
                            class="px-4 py-2 bg-red-500 text-white rounded">Eliminar</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>