<div class="p-6">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Historia Clínica') }}
        </h2>
    </x-slot>
    <button wire:click="create" type="button" class="px-4 py-2 bg-blue-500 text-white rounded">Nueva Historia Clínica</button>

    <div class="mb-4">
        <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Buscar por mascota" class="w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" />
<!---
        <button wire:click="searchdata" class="px-4 py-2 bg-blue-500 text-white rounded">Filtrar</button>
-->
    </div>


    @if($isOpen)
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex justify-center items-center">
        <div class="bg-white p-6 rounded shadow-md w-full max-w-lg max-h-[90vh] overflow-y-auto mx-4 sm:mx-auto">
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
                
                        
                       
                
                    </div>

                    <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded">Guardar</button>
                    <button type="button" wire:click="$set('isOpen', false)" class="px-4 py-2 bg-gray-500 text-white rounded">Cancelar</button>
                </form>
            </div>
        </div>
    @endif
    
    
    <!-- Tabla -->
    <div class="overflow-x-auto overflow-y-auto max-h-[500px]">
        @if($clinicalHistories)
        <table  id="clinicalHistoryTable" class="min-w-full table-auto border-collapse bg-white shadow-md rounded-lg">
            <thead class="bg-gray-200">
                <tr class="bg-gray-100">
                    <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">ID</th>
                    <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Nombre de la Mascota</th>
                    <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Raza</th>

                    <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Fecha de Nacimiento</th>
                    <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Dueño</th>
                    <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($clinicalHistories as $history)
                    <tr class="border-t">
                        <td class="py-3 px-4 text-sm text-gray-600">{{ $history->id }}</td>
                        <td class="py-3 px-4 text-sm text-gray-600">{{ $history->pet_name }}</td>
                        <td class="py-3 px-4 text-sm text-gray-600">{{ $history->breed }}</td>
                        <td class="py-3 px-4 text-sm text-gray-600">{{ ($history->birth_date)  ? \Carbon\Carbon::parse($history->birth_date)->format('d/m/Y') : 'N/A' }}</td>
                        <td class="py-3 px-4 text-sm text-gray-600">{{ $history->owner_name }}</td>

                        <td class="py-3 px-4 text-sm">
                            <button  type="button" wire:click="showDetails({{ $history->id }})"
                                class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-700">
                            Detalles
                        </button>
                        
                     
                            <button  type="button" wire:click="openDetailModal({{ $history->id }})"
                                class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-700">
                            (+)Servicio
                        

                            <button wire:click="edit({{ $history->id }})" class="text-blue-500 hover:text-blue-700">Editar</button>
                            @can('delete records')
                            <button wire:click="delete({{ $history->id }})" class="text-red-500 hover:text-red-700 ml-2">Eliminar</button>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <!-- Paginación -->
    
        <!-- Modal para agregar detalle -->
@if($showDetailModal)
<div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex justify-center items-center z-50">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h3 class="text-lg font-semibold">Agregar Detalle</h3>
        
        <form wire:submit.prevent="addDetail">
            <div class="mb-4">
                <label for="service" class="block text-sm font-medium text-gray-700">Servicio</label>
                <!---
                <input type="text" id="service" wire:model="service" class="block w-full border-gray-300 rounded-md">
                -->
                <!---
                <select id="service" wire:model="service" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Seleccione un servicio</option>
                    <option value="BAÑO">BAÑO</option>
                    <option value="BAÑO Y CORTE">BAÑO Y CORTE</option>
                    <option value="CORTE DE UÑAS">CORTE DE UÑAS</option>
                    <option value="BAÑO - CORTE - PIGMENTACIÓN DE PELO">BAÑO - CORTE - PIGMENTACIÓN DE PELO</option>
                </select>-->
                <select id="service" wire:model="service" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Seleccione un servicio</option>
                    @foreach(\App\Models\Service::all() as $service)
                        <option value="{{ $service->name }}">{{ $service->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="rate" class="block text-sm font-medium text-gray-700">Tarifa en S/</label>
                <input type="number" id="rate" wire:model="rate" class="block w-full border-gray-300 rounded-md">
            </div>

            <div class="mb-4">
                <label for="payment_method" class="block text-sm font-medium text-gray-700">Método de Pago</label>
                <select id="payment_method" wire:model="payment_method" class="block w-full border-gray-300 rounded-md">
                    <option value="">Seleccione</option>
                    <option value="efectivo">Efectivo</option>
                    <option value="tarjeta">Tarjeta</option>
                    <option value="yape">Yape</option>
                    <option value="plin">Plin</option>
                    <option value="transferencia">Transferencia</option>
                    <option value="izipay">Izipay</option>

                    
                </select>
            </div>

            <div class="mb-4">
                <label for="service_datetime" class="block text-sm font-medium text-gray-700">Fecha y Hora del Servicio</label>
                <input type="datetime-local" id="service_datetime" wire:model="service_datetime" class="block w-full border-gray-300 rounded-md">
            </div>

            <div class="mb-4">
                <label for="observation" class="block text-sm font-medium text-gray-700">Observación</label>
                <textarea id="observation" wire:model="observationdetail" class="block w-full border-gray-300 rounded-md"></textarea>
            </div>

            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Guardar Detalle</button>
        </form>

        <button wire:click="closeDetailModal" class="mt-4 px-4 py-2 bg-gray-500 text-white rounded-md">Cerrar</button>
    </div>
</div>
@endif

        <!-- Modal de detalles -->
    @if ($showModal)
    <div x-data="{ open: @entangle('showModal') }">
        <!-- Fondo oscuro -->
        <div x-show="open" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
            <!-- Contenedor del Modal -->
            <div class="bg-white p-6 rounded-lg shadow-lg max-w-4xl w-full">

                <h2 class="text-lg font-semibold mb-4">Detalles del Registro</h2>
                
                @if ($selectedHistory)
                    <p><strong>Nombre de la Mascota:</strong> {{ $selectedHistory->pet_name }}</p>
                    <p><strong>Dueño:</strong> {{ $selectedHistory->owner_name }}</p>
                    <p><strong>Teléfono:</strong> {{ $selectedHistory->phone1 }}</p>
                    <p><strong>Teléfono 2:</strong> {{ $selectedHistory->phone2 }}</p>

                    <p><strong>Detalles Extra:</strong> {{ $selectedHistory->observation }}</p>
                @endif
                


            <!-- Tabla de Servicios Registrados -->
            <h3 class="text-lg font-semibold mt-4">Servicios Registrados</h3>
            <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-gray-200 bg-white border">
                <thead>
                    <tr>
                        <th class="py-2 px-4">Servicio</th>
                        <th class="py-2 px-4">Tarifa</th>
                        <th class="py-2 px-4">Método de Pago</th>
                        <th class="py-2 px-4">Fecha y Hora</th>
                        <th class="py-2 px-4">Observaciones</th>
                        <th class="py-2 px-4">Acciones</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($selectedHistory->details as $detail)
                        <tr>
                            <td class="py-2 px-4">{{ $detail->service }}</td>
                            <td class="py-2 px-4">{{ $detail->rate }}</td>
                            <td class="py-2 px-4">{{ $detail->payment_method }}</td>
                            <td class="py-2 px-4">{{ \Carbon\Carbon::parse($detail->service_datetime)->format('d/m/Y H:i') }}</td>
                            <td class="py-2 px-4">{{ $detail->observation }}</td>

                            <td class="py-2 px-4">
                                @can('delete records')

                                <button wire:click="deleteService({{ $detail->id }})"
                                        class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-700">
                                    Eliminar
                                </button>
                                
                                @endcan
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
            
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