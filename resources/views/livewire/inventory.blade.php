<div class="p-6">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Inventario') }}
        </h2>
    </x-slot>

    <!-- Formulario para agregar/editar inventario -->
    <div class="mb-6 bg-white p-4 rounded shadow-md">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <input type="text" wire:model="description" placeholder="Descripción"
                    class="w-full border rounded px-3 py-2" />
                @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <input type="number" wire:model="quantity" placeholder="Cantidad"
                    class="w-full border rounded px-3 py-2" />
                @error('quantity') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <input type="number" wire:model="price" step="0.01" placeholder="Precio"
                    class="w-full border rounded px-3 py-2" />
                @error('price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <input type="text" wire:model="unit" placeholder="Unidad de medida"
                    class="w-full border rounded px-3 py-2" />
                @error('unit') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <input type="file" wire:model="image"
                    class="w-full border rounded px-3 py-2" />
                @error('image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <div>
                <select wire:model="idcategoria" class="w-full border rounded px-3 py-2">
                    <option value="">Selecciona una categoría</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('idcategoria') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <div>
                <select wire:model="idestado" class="w-full border rounded px-3 py-2">
                    <option value="">Selecciona un estado</option>
                    <option value="1">Activo</option>
                    <option value="2">Inactivo</option>
                    <!-- Puedes ajustar esto si tienes una tabla de estados -->
                </select>
                @error('idestado') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="mt-4">
            <button wire:click="{{ $editMode ? 'updateInventory' : 'addInventory' }}"
                class="px-4 py-2 bg-green-600 text-white rounded">
                {{ $editMode ? 'Actualizar' : 'Agregar Inventario' }}
            </button>
        </div>
    </div>

    <!-- Mensaje de éxito -->
    @if (session()->has('message'))
        <div class="text-green-600 font-medium mb-4">{{ session('message') }}</div>
    @endif

    <!-- Tabla de Inventario -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white rounded-lg shadow-md">
            <thead class="bg-gray-100 text-left">
                <tr>
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Descripción</th>
                    <th class="px-4 py-2">Cantidad</th>
                    <th class="px-4 py-2">Precio</th>
                    <th class="px-4 py-2">Unidad</th>
                    <th class="px-4 py-2">Categoría</th>

                    <th class="px-4 py-2">Estado</th>
                    <th class="px-4 py-2">Imagen</th>
                    <th class="px-4 py-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($inventories as $item)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $item->id }}</td>
                        <td class="px-4 py-2">{{ $item->description }}</td>
                        <td class="px-4 py-2">{{ $item->quantity }}</td>
                        <td class="px-4 py-2">S/ {{ number_format($item->price, 2) }}</td>
                        <td class="px-4 py-2">{{ $item->unit }}</td>
                        <td class="px-4 py-2">{{ $item->category->name ?? 'Sin categoría' }}</td>

                        <td class="px-4 py-2">{{ $item->idestado == 1 ? 'Activo' : 'Inactivo' }}</td>
                        <td class="px-4 py-2">
                            @if ($item->image)
                                <img
                                    src="{{ Storage::url($item->image) }}"
                                    class="h-12 w-12 rounded cursor-pointer transition hover:scale-110"
                                    onclick="showImageModal('{{ Storage::url($item->image) }}')"
                                />
                            @else
                                <span class="text-gray-400">Sin imagen</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 space-x-2">
                            <button wire:click="editInventory({{ $item->id }})"
                                class="px-3 py-1 bg-blue-500 text-white rounded">Editar</button>
                            <button wire:click="deleteInventory({{ $item->id }})"
                                class="px-3 py-1 bg-red-500 text-white rounded">Eliminar</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!--- -->
    <!-- Modal de vista previa de imagen -->
<div id="imageModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60">
    <div class="relative bg-white p-4 rounded shadow-lg max-w-2xl max-h-[90vh]">
        <button onclick="closeImageModal()" class="absolute top-2 right-2 text-gray-600 hover:text-black text-xl">
            &times;
        </button>
        <img id="modalImage" src="" alt="Vista previa" class="max-w-full max-h-[80vh] rounded">
    </div>
</div>

<script>
    function showImageModal(src) {
        const modal = document.getElementById('imageModal');
        const modalImg = document.getElementById('modalImage');
        modalImg.src = src;
        modal.classList.remove('hidden');
    }

    function closeImageModal() {
        document.getElementById('imageModal').classList.add('hidden');
    }

    // Opcional: cerrar al hacer clic fuera de la imagen
    document.addEventListener('click', function(event) {
        const modal = document.getElementById('imageModal');
        if (event.target === modal) {
            closeImageModal();
        }
    });
</script>
</div>