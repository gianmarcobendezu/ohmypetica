<div class="p-6 max-w-5xl mx-auto bg-white shadow rounded">
    <h2 class="text-2xl font-bold mb-4">Editar Orden</h2>

    <form wire:submit.prevent="update">

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block mb-1">Cliente</label>
                <input type="text" wire:model.defer="customer_name" class="w-full border p-2 rounded">
            </div>

            <div>
                <label class="block mb-1">Teléfono</label>
                <input type="text" wire:model.defer="customer_phone" class="w-full border p-2 rounded">
            </div>

            <div>
                <label class="block mb-1">Fecha de Orden</label>
                <input type="datetime-local" wire:model.defer="order_datetime" class="w-full border p-2 rounded">
            </div>

            <div>
                <label class="block mb-1">Método de Pago</label>
                <input type="text" wire:model.defer="payment_method" class="w-full border p-2 rounded">
            </div>

            <div>
                <label class="block mb-1">Historia Clínica</label>
                <select wire:model="clinical_history_id" class="w-full border p-2 rounded">
                    <option value="">-- Seleccionar --</option>
                    @foreach($histories as $history)
                        <option value="{{ $history->id }}">{{ $history->pet_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-span-2">
                <label class="block mb-1">Observación</label>
                <textarea wire:model.defer="observation" class="w-full border p-2 rounded" rows="3"></textarea>
            </div>
        </div>

        <hr class="my-4">

        {{-- Productos --}}
        <h3 class="text-xl font-semibold mb-2">Productos</h3>
        @foreach ($items as $index => $item)
            <div class="grid grid-cols-5 gap-2 items-center mb-2">
                <select wire:model="items.{{ $index }}.inventory_id"
                        wire:change="updateItemRow({{ $index }})"
                        class="border p-2 rounded">
                    <option value="">-- Producto --</option>
                    @foreach($inventories as $inv)
                        <option value="{{ $inv->id }}">{{ $inv->description }} (S/. {{ $inv->price }})</option>
                    @endforeach
                </select>

                <input type="number"
                       wire:model.lazy="items.{{ $index }}.quantity"
                       wire:change="updateItemRow({{ $index }})"
                       min="1"
                       class="border p-2 rounded"
                       placeholder="Cantidad">

                <input type="text"
                       wire:model="items.{{ $index }}.unit_price"
                       class="border p-2 rounded bg-gray-100"
                       readonly>

                <input type="text"
                       wire:model="items.{{ $index }}.subtotal"
                       class="border p-2 rounded bg-gray-100"
                       readonly>

                <button type="button" wire:click="removeItem({{ $index }})" class="text-red-500 font-bold">✖</button>
            </div>
        @endforeach

        <button type="button" wire:click="addItem" class="mt-2 text-sm text-blue-600">+ Agregar producto</button>

        <hr class="my-4">

        {{-- Servicios --}}
        <h3 class="text-xl font-semibold mb-2">Servicios</h3>
        @foreach ($services as $index => $service)
            <div class="grid grid-cols-5 gap-2 items-center mb-2">
                <input type="text" wire:model="services.{{ $index }}.service" class="border p-2 rounded" placeholder="Servicio">
                <input type="number" wire:model="services.{{ $index }}.rate" class="border p-2 rounded" placeholder="Tarifa">
                <input type="text" wire:model="services.{{ $index }}.observation" class="border p-2 rounded" placeholder="Observación">
                <input type="datetime-local" wire:model="services.{{ $index }}.service_datetime" class="border p-2 rounded">
                <button type="button" wire:click="removeService({{ $index }})" class="text-red-500 font-bold">✖</button>
            </div>
        @endforeach

        <button type="button" wire:click="addService" class="mt-2 text-sm text-blue-600">+ Agregar servicio</button>

        <div class="flex justify-between items-center mt-6">
            <div class="text-xl font-semibold">
                Total: S/. {{ number_format($this->total, 2) }}
            </div>

            <div class="space-x-2">
                <a href="{{ route('orders.index') }}" class="text-gray-600 hover:underline">← Volver</a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded">
                    Guardar Cambios
                </button>
            </div>
        </div>
    </form>
</div>