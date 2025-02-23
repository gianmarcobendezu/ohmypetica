<div class="p-6 bg-white shadow-md rounded-lg">
    <h2 class="text-lg font-semibold text-gray-700">Recordatorio de Baño</h2>
    <table class="min-w-full table-auto border-collapse bg-white shadow-md rounded-lg mt-4">
        <thead class="bg-gray-200">
            <tr>
                <th class="py-2 px-4 text-left text-sm font-semibold text-gray-700">Mascota</th>
                <th class="py-2 px-4 text-left text-sm font-semibold text-gray-700">Último Baño</th>
                <th class="py-2 px-4 text-left text-sm font-semibold text-gray-700">Días Transcurridos</th>
                <th class="py-2 px-4 text-left text-sm font-semibold text-gray-700">Total de Baños</th>

                <th class="py-2 px-4 text-left text-sm font-semibold text-gray-700">Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bathReminders as $reminder)
                <tr class="border-t {{ $reminder['needs_reminder'] ? 'bg-red-100' : '' }}">
                    <td class="py-3 px-4 text-sm text-gray-600">{{ $reminder['pet_name'] }}</td>
                    <td class="py-3 px-4 text-sm text-gray-600">{{ $reminder['last_bath_date'] }}</td>
                    <td class="py-3 px-4 text-sm text-gray-600">{{ $reminder['days_since_last_bath'] }}</td>
                    <td class="py-3 px-4 text-sm text-gray-600">{{ $reminder['total_baths'] }}</td>
                    
                    <td class="py-3 px-4 text-sm">
                        @if($reminder['needs_reminder'])
                            <span class="px-2 py-1 text-xs font-semibold text-white bg-red-500 rounded-full">
                                ¡Requiere Baño!
                            </span>
                        @else
                            <span class="px-2 py-1 text-xs font-semibold text-white bg-green-500 rounded-full">
                                Baño Reciente
                            </span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>