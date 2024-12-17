<div class="p-6">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Historia Clínica') }}
        </h2>
    </x-slot>
    <button wire:click="create" type="button" class="px-4 py-2 bg-blue-500 text-white rounded">Nueva Historia Clínica</button>

    <div class="mb-4">
        <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Buscar por mascota o servicio" class="w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" />
<!---
        <button wire:click="searchdata" class="px-4 py-2 bg-blue-500 text-white rounded">Filtrar</button>
-->
    </div>


    @if($isOpen)
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex justify-center items-center">
            <div class="bg-white p-6 rounded shadow-md">
                <h2 class="text-lg font-bold">Historia Clínica</h2>

                <form wire:submit.prevent="store" class="space-y-4">
                    <!-- Campos -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <!-- Nombre de la mascota -->
                        <div class="mb-4">
                            <label for="pet_name" class="block text-gray-700">Nombre de la Mascota</label>
                            <input type="text" id="pet_name" wire:model="pet_name" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
                            @error('pet_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                
                        <!-- Raza -->
                        <div class="mb-4">
                            <label for="breed" class="block text-gray-700">Raza</label>
                            <input type="text" id="breed" wire:model="breed" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
                            @error('breed') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                
                        <!-- Fecha de nacimiento -->
                        <div class="mb-4">
                            <label for="birth_date" class="block text-gray-700">Fecha de Nacimiento</label>
                            <input type="date" id="birth_date" wire:model="birth_date" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
                            @error('birth_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                
                        <!-- Servicio -->
                        <div class="mb-4">
                            <label for="service" class="block text-gray-700">Servicio</label>
                            <input type="text" id="service" wire:model="service" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
                            @error('service') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                
                        <!-- Observación -->
                        <div class="mb-4">
                            <label for="observation" class="block text-gray-700">Observación</label>
                            <input type="text" id="observation" wire:model="observation" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
                            @error('observation') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                
                        <!-- Nombre del dueño -->
                        <div class="mb-4">
                            <label for="owner_name" class="block text-gray-700">Nombre del Dueño</label>
                            <input type="text" id="owner_name" wire:model="owner_name" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
                            @error('owner_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                
                        <!-- Teléfono 1 -->
                        <div class="mb-4">
                            <label for="phone1" class="block text-gray-700">Teléfono 1</label>
                            <input type="number" id="phone1" wire:model="phone1" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
                            @error('phone1') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                
                        <!-- Teléfono 2 -->
                        <div class="mb-4">
                            <label for="phone2" class="block text-gray-700">Teléfono 2</label>
                            <input type="number" id="phone2" wire:model="phone2" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
                            @error('phone2') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                
                        <!-- Tarifa -->
                        <div class="mb-4">
                            <label for="rate" class="block text-gray-700">Tarifa</label>
                            <input type="number" id="rate" wire:model="rate" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
                            @error('rate') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                
                        <!-- Método de pago -->
                        <div class="mb-4">
                            <label for="payment_method" class="block text-gray-700">Método de Pago</label>
                            <input type="text" id="payment_method" wire:model="payment_method" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
                            @error('payment_method') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                
                    </div>

                    <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded">Guardar</button>
                    <button type="button" wire:click="$set('isOpen', false)" class="px-4 py-2 bg-gray-500 text-white rounded">Cancelar</button>
                </form>
            </div>
        </div>
    @endif
    
    
    <!-- Tabla -->
    <div class="overflow-x-auto">
        @if($clinicalHistories)
        <table  id="clinicalHistoryTable" class="min-w-full table-auto bg-white shadow-md rounded-lg">
            <thead class="bg-gray-200">
                <tr>
                    <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">ID</th>
                    <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Nombre de la Mascota</th>
                    <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Servicio</th>
                    <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Fecha de Nacimiento</th>
                    <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($clinicalHistories as $history)
                    <tr class="border-t">
                        <td class="py-3 px-4 text-sm text-gray-600">{{ $history->id }}</td>
                        <td class="py-3 px-4 text-sm text-gray-600">{{ $history->pet_name }}</td>
                        <td class="py-3 px-4 text-sm text-gray-600">{{ $history->service }}</td>
                        <td class="py-3 px-4 text-sm text-gray-600">{{ \Carbon\Carbon::parse($history->birth_date)->format('d/m/Y') }}</td>
                        <td class="py-3 px-4 text-sm">
                            <button  type="button" wire:click="showDetails({{ $history->id }})"
                                class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-700">
                            Ver Detalles
                        </button>
                            <button wire:click="edit({{ $history->id }})" class="text-blue-500 hover:text-blue-700">Editar</button>
                            
                            <button wire:click="delete({{ $history->id }})" class="text-red-500 hover:text-red-700 ml-2">Eliminar</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <!-- Paginación -->
        
        <!-- Modal de detalles -->
    @if ($showModal)
    <div x-data="{ open: @entangle('showModal') }">
        <!-- Fondo oscuro -->
        <div x-show="open" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
            <!-- Contenedor del Modal -->
            <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full">
                <h2 class="text-lg font-semibold mb-4">Detalles del Registro</h2>
                
                @if ($selectedHistory)
                    <p><strong>Nombre de la Mascota:</strong> {{ $selectedHistory->pet_name }}</p>
                    <p><strong>Servicio:</strong> {{ $selectedHistory->service }}</p>
                    <p><strong>Dueño:</strong> {{ $selectedHistory->owner_name }}</p>
                    <p><strong>Teléfono:</strong> {{ $selectedHistory->phone1 }}</p>
                    <p><strong>Teléfono 2:</strong> {{ $selectedHistory->phone2 }}</p>
                    <p><strong>Tarifa:</strong> {{ $selectedHistory->rate }}</p>
                    <p><strong>Método de Pago:</strong> {{ $selectedHistory->payment_method }}</p>

                    <p><strong>Detalles Extra:</strong> {{ $selectedHistory->observation }}</p>
                @endif

                <!-- Botón de Cerrar -->
                <div class="mt-4 text-right">
                    <button @click="open = false" wire:click="closeModal" 
                            class="px-3 py-1 bg-gray-500 text-white rounded hover:bg-gray-700">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

    @else
    <p>No se encontraron historias clínicas.</p>
@endif
    </div>
</div>
<script>
    function filterTable() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("searchInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("clinicalHistoryTable");
        tr = table.getElementsByTagName("tr");
        
        for (i = 1; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td");
            var rowMatches = false;

            for (var j = 0; j < td.length; j++) {
                if (td[j]) {
                    txtValue = td[j].textContent || td[j].innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        rowMatches = true;
                    }
                }
            }

            if (rowMatches) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
</script>