<div class="p-6 max-w-6xl mx-auto bg-white shadow rounded">
    <h2 class="text-2xl font-bold mb-4">Editar Orden</h2>

    <form wire:submit.prevent="update">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
                <label class="block font-semibold">Cliente:</label>
                <input type="text" wire:model.defer="customer_name" class="w-full border p-2 rounded" placeholder="Nombre del cliente (opcional)">
            </div>

            <div>
                <label class="block font-semibold">Teléfono:</label>
                <input type="text" wire:model.defer="customer_phone" class="w-full border p-2 rounded" placeholder="Teléfono del cliente (opcional)">
            </div>

            <div>
                <label class="block font-semibold">Fecha de Orden:</label>
                <input type="datetime-local" wire:model.defer="order_datetime" class="w-full border p-2 rounded">
            </div>

            <div>
                <label class="block font-semibold">Método de Pago:</label>
                <select wire:model.defer="payment_method" class="w-full border p-2 rounded">
                    <option value="">-- Seleccionar --</option>
                    <option value="Efectivo">Efectivo</option>
                    <option value="Tarjeta">Tarjeta</option>
                    <option value="Yape/Plin">Yape/Plin</option>
                </select>
            </div>

            <div>
                <label class="block font-semibold">Historia Clínica:</label>
                <select wire:model.defer="clinical_history_id" class="w-full border p-2 rounded">
                    <option value="">-- Seleccionar --</option>
                    @foreach($histories as $history)
                        <option value="{{ $history->id }}">{{ $history->pet_name }} - {{ $history->owner_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="md:col-span-2">
                <label class="block font-semibold">Observaciones:</label>
                <textarea wire:model.defer="observation" class="w-full border p-2 rounded" rows="3"></textarea>
            </div>
        </div>

        {{-- Buscador y catálogo de productos --}}
        <h3 class="text-xl font-semibold mb-2">Productos</h3>
        <div class="mb-4">
            <input type="text" wire:model.live="search" placeholder="Buscar producto..." class="w-full p-2 border rounded">
        </div>
        <p class="text-sm text-gray-500">Buscando: "{{ $search }}" — Resultados: {{ count($filteredInventories) }}</p>

        <div class="overflow-x-auto whitespace-nowrap mb-6">
            <div class="flex gap-4">
                @foreach ($filteredInventories as $inv)
                    <div class="min-w-[200px] border rounded p-2 shadow hover:shadow-lg transition transform hover:scale-105 cursor-pointer"
                        wire:click="selectProduct({{ $inv->id }})">
                        <img src="{{ asset('storage/' . $inv->image) }}" class="w-full h-32 object-cover mb-2 rounded" alt="imagen">
                        <h4 class="font-semibold text-sm truncate">{{ $inv->description }}</h4>
                        <p class="text-gray-700 text-sm">S/. {{ number_format($inv->price, 2) }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Tabla de carrito --}}
        @if (count($items)>0)
            <h3 class="text-xl font-semibold mb-2">Carrito de productos seleccionados</h3>
            <div class="grid grid-cols-6 gap-2 items-center mb-2 font-semibold text-sm text-gray-600">
                <span>Cantidad</span>
                <span>Precio Unitario</span>
                <span>Subtotal</span>
                <span>Observación</span>
                <span>Producto</span>
                <span>Acción</span>
            </div>
        @endif

        @foreach ($items as $index => $item)
            <div class="grid grid-cols-6 gap-2 items-center mb-2" wire:key="item-{{ $index }}">
                <input type="number"
                    wire:model.lazy="items.{{ $index }}.quantity"
                    wire:change="updateItemRow({{ $index }})"
                    min="1"
                    class="border p-2 rounded"/>

                <input type="text"
                    wire:model.lazy="items.{{ $index }}.unit_price"
                    wire:change="updateItemRow({{ $index }})"
                    class="border p-2 rounded"/>

                <input type="text"
                    wire:model="items.{{ $index }}.subtotal"
                    class="border p-2 rounded bg-gray-100"
                    readonly/>

                <input type="text"
                    wire:model="items.{{ $index }}.observation"
                    class="border p-2 rounded"
                    placeholder="Nota / Observación"/>

                <span class="text-sm text-gray-700">{{ $item['product_name'] ?? '-' }}</span>

                <button type="button" wire:click="removeItem({{ $index }})" class="text-red-500 font-bold">✖</button>
            </div>
        @endforeach

        {{-- Servicios --}}
        <h3 class="text-xl font-semibold mb-2 mt-6">Servicios</h3>
        @foreach ($services as $index => $srv)
            <div class="grid grid-cols-5 gap-2 items-center mb-2" wire:key="srv-{{ $index }}">
                <input type="text" wire:model="services.{{ $index }}.service" class="border p-2 rounded" placeholder="Nombre del servicio">
                <input type="number"
                    wire:model.lazy="services.{{ $index }}.rate"
                    wire:change="recalculateServiceRate({{ $index }})"
                    class="border p-2 rounded"
                    placeholder="Tarifa">
                <input type="datetime-local" wire:model="services.{{ $index }}.service_datetime" class="border p-2 rounded">
                <input type="text" wire:model="services.{{ $index }}.observation" class="border p-2 rounded" placeholder="Observación">
                <button type="button" wire:click="removeService({{ $index }})" class="text-red-500 font-bold">✖</button>
            </div>
        @endforeach
        <button type="button" wire:click="addService" class="mb-4 text-blue-600">+ Agregar servicio</button>

        {{-- Total y botón guardar --}}
        <div class="mt-6 flex justify-between items-center">
            <h4 class="text-lg font-bold">Total: S/. {{ number_format($this->total, 2) }}</h4>
            <div class="space-x-2">
                <a href="{{ route('orders.index') }}" class="text-gray-600 hover:underline">← Volver</a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded">
                    Guardar Cambios
                </button>
            </div>
        </div>
    </form>
</div>