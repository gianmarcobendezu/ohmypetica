<div class="p-6">
    <h2 class="text-2xl font-bold mb-4 text-gray-700">Categorías</h2>

    <div class="mb-4">
        <input type="text" wire:model="name" placeholder="Nombre de categoría"
            class="border rounded px-4 py-2 w-full">
        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        
        
        @if($editMode)
            <button wire:click="updateCategory" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded">Actualizar</button>
            <button wire:click="resetInput" class="mt-2 bg-gray-500 text-white px-4 py-2 rounded">Cancelar</button>
        @else
            <button wire:click="saveCategory" class="mt-2 bg-green-500 text-white px-4 py-2 rounded">Guardar</button>
        @endif
    </div>
    

    @if (session()->has('message'))
        <div class="text-green-600">{{ session('message') }}</div>
    @endif

    <table class="min-w-full bg-white shadow rounded">
        <thead class="bg-gray-100 text-left">
            <tr>
                <th class="px-4 py-2">ID</th>
                <th class="px-4 py-2">Nombre</th>
                <th class="px-4 py-2">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $category->id }}</td>
                    <td class="px-4 py-2">{{ $category->name }}</td>
                    <td class="px-4 py-2">
                        <button wire:click="editCategory({{ $category->id }})"
                            class="text-blue-600 hover:underline mr-2">Editar</button>
                        <button wire:click="deleteCategory({{ $category->id }})"
                            class="text-red-600 hover:underline">Eliminar</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>