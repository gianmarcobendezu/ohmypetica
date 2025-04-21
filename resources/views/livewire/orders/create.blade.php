<form action="{{ route('orders.store') }}" method="POST" class="p-6 max-w-5xl mx-auto">
    @csrf
    <h1 class="text-2xl font-bold mb-6">Registrar Nueva Orden</h1>

    {{-- Selección de historia clínica --}}
    <div class="mb-4">
        <label class="block mb-1 font-semibold">Historia Clínica (opcional)</label>
        <select name="clinical_history_id" class="w-full border p-2 rounded">
            <option value="">Venta rápida</option>
            @foreach ($clinicalHistories as $history)
                <option value="{{ $history->id }}">{{ $history->owner_name }} - {{ $history->pet_name }}</option>
            @endforeach
        </select>
    </div>

    {{-- Servicios --}}
    <div class="mb-6">
        <h2 class="text-lg font-semibold mb-2">Servicios</h2>
        <div id="services-container"></div>
        <button type="button" onclick="addService()" class="bg-blue-500 text-white px-3 py-1 rounded mt-2">+ Agregar Servicio</button>
    </div>

    {{-- Productos --}}
    <div class="mb-6">
        <h2 class="text-lg font-semibold mb-2">Productos</h2>
        <div id="items-container"></div>
        <button type="button" onclick="addItem()" class="bg-green-500 text-white px-3 py-1 rounded mt-2">+ Agregar Producto</button>
    </div>

    <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded mt-4">Registrar Orden</button>
</form>
<script>
    let itemOptions = `@foreach($items as $item)<option value="{{ $item->id }}">{{ $item->name }} (Stock: {{ $item->stock }})</option>@endforeach`;
    
    function addService() {
        const html = `
            <div class="mb-4 border p-3 rounded bg-gray-100">
                <input type="text" name="services[][service_name]" placeholder="Nombre del servicio" class="border p-2 rounded w-full mb-2" required>
                <input type="number" name="services[][price]" placeholder="Precio" class="border p-2 rounded w-full mb-2" step="0.01" required>
                <select name="services[][payment_method]" class="border p-2 rounded w-full" required>
                    <option value="Efectivo">Efectivo</option>
                    <option value="Yape">Yape</option>
                    <option value="Tarjeta">Tarjeta</option>
                </select>
            </div>
        `;
        document.getElementById('services-container').insertAdjacentHTML('beforeend', html);
    }
    
    function addItem() {
        const html = `
            <div class="mb-4 border p-3 rounded bg-gray-100">
                <select name="items[][item_id]" class="border p-2 rounded w-full mb-2" required>
                    ${itemOptions}
                </select>
                <input type="number" name="items[][quantity]" placeholder="Cantidad" class="border p-2 rounded w-full" min="1" required>
            </div>
        `;
        document.getElementById('items-container').insertAdjacentHTML('beforeend', html);
    }
    </script>