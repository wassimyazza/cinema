@extends('layouts.admin')

@section('title', 'Ajouter une salle - Administration CinéHall')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
        <div class="lg:flex lg:items-center lg:justify-between mb-6">
            <div class="flex-1 min-w-0">
                <h1 class="text-2xl font-semibold text-gray-900">Ajouter une nouvelle salle</h1>
                <p class="mt-1 text-sm text-gray-500">
                    Créez une nouvelle salle dans le cinéma CinéHall
                </p>
            </div>
            <div class="mt-5 flex lg:mt-0 lg:ml-4">
                <a href="{{ route('admin.theaters.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Retour à la liste
                </a>
            </div>
        </div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
        <form action="{{ route('admin.theaters.store') }}" method="POST" class="space-y-8">
            @csrf
            
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Informations de la salle
                    </h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">
                        Détails de la nouvelle salle
                    </p>
                </div>
                <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        <div class="sm:col-span-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Nom de la salle</label>
                            <div class="mt-1">
                                <input type="text" name="name" id="name" value="{{ old('name') }}" required class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                            @error('name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-2 text-sm text-gray-500">Le nom doit être unique et identifiable facilement</p>
                        </div>
                        
                        <div class="sm:col-span-3">
                            <label for="capacity" class="block text-sm font-medium text-gray-700">Capacité (places)</label>
                            <div class="mt-1">
                                <input type="number" name="capacity" id="capacity" value="{{ old('capacity') }}" min="1" required class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                            @error('capacity')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-2 text-sm text-gray-500">Nombre total de sièges dans la salle</p>
                        </div>
                        
                        <div class="sm:col-span-3">
                            <label for="type" class="block text-sm font-medium text-gray-700">Type de salle</label>
                            <div class="mt-1">
                                <select id="type" name="type" required class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    <option value="Normal" {{ old('type') == 'Normal' ? 'selected' : '' }}>Normal</option>
                                    <option value="VIP" {{ old('type') == 'VIP' ? 'selected' : '' }}>VIP</option>
                                </select>
                            </div>
                            @error('type')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-2 text-sm text-gray-500">Détermine le type de confort et le tarif des places</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Configuration des sièges
                    </h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">
                        Définissez la disposition des sièges dans la salle
                    </p>
                </div>
                <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                    <p class="text-sm text-gray-600 mb-4">
                        Après avoir créé la salle, vous pourrez ajouter et configurer les sièges individuellement dans la section de gestion des sièges.
                    </p>
                    
                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        <div class="sm:col-span-3">
                            <label for="row_count" class="block text-sm font-medium text-gray-700">Nombre de rangées</label>
                            <div class="mt-1">
                                <input type="number" name="row_count" id="row_count" value="{{ old('row_count', 10) }}" min="1" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                            <p class="mt-2 text-sm text-gray-500">Nombre de rangées de sièges</p>
                        </div>
                        
                        <div class="sm:col-span-3">
                            <label for="seats_per_row" class="block text-sm font-medium text-gray-700">Sièges par rangée</label>
                            <div class="mt-1">
                                <input type="number" name="seats_per_row" id="seats_per_row" value="{{ old('seats_per_row', 12) }}" min="1" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                            <p class="mt-2 text-sm text-gray-500">Nombre de sièges par rangée</p>
                        </div>
                        
                        <div class="sm:col-span-6">
                            <div class="relative flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="auto_generate_seats" name="auto_generate_seats" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded" checked>
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="auto_generate_seats" class="font-medium text-gray-700">Générer automatiquement les sièges</label>
                                    <p class="text-gray-500">Les sièges seront créés automatiquement selon la configuration définie</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="sm:col-span-6">
                            <div class="relative flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="include_couple_seats" name="include_couple_seats" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded" {{ old('include_couple_seats') ? 'checked' : '' }}>
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="include_couple_seats" class="font-medium text-gray-700">Inclure des sièges couple</label>
                                    <p class="text-gray-500">Ajouter des sièges couple dans les dernières rangées</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Aperçu de la configuration</h4>
                        <div class="bg-gray-50 p-4 rounded-md border border-gray-200">
                            <div class="mb-4 w-3/4 mx-auto">
                                <div class="h-4 bg-indigo-200 rounded text-center text-xs text-indigo-800 leading-4">ÉCRAN</div>
                            </div>
                            
                            <div id="seats-preview" class="mt-6 text-center">
                                <p class="text-sm text-gray-500">L'aperçu sera généré en fonction de vos paramètres</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="flex justify-end">
                <a href="{{ route('admin.theaters.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Annuler
                </a>
                <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Créer la salle
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const rowCountInput = document.getElementById('row_count');
    const seatsPerRowInput = document.getElementById('seats_per_row');
    const capacityInput = document.getElementById('capacity');
    const autoGenerateSeatsCheckbox = document.getElementById('auto_generate_seats');
    const includeCoupleSeatCheckbox = document.getElementById('include_couple_seats');
    const seatsPreview = document.getElementById('seats-preview');
    
    // Update capacity based on rows and seats
    function updateCapacity() {
        const rows = parseInt(rowCountInput.value) || 0;
        const seatsPerRow = parseInt(seatsPerRowInput.value) || 0;
        capacityInput.value = rows * seatsPerRow;
    }
    
    // Generate seats preview
    function updateSeatsPreview() {
        const rows = parseInt(rowCountInput.value) || 0;
        const seatsPerRow = parseInt(seatsPerRowInput.value) || 0;
        const includeCouple = includeCoupleSeatCheckbox.checked;
        
        if (rows <= 0 || seatsPerRow <= 0) {
            seatsPreview.innerHTML = '<p class="text-sm text-gray-500">Veuillez définir un nombre valide de rangées et de sièges</p>';
            return;
        }
        
        let previewHTML = '';
        
        // Limit preview to 6 rows max for display purposes
        const displayRows = Math.min(rows, 6);
        const displaySeats = Math.min(seatsPerRow, 20); // Limit to 20 seats per row for display
        
        for (let i = 0; i < displayRows; i++) {
            const rowLabel = String.fromCharCode(65 + i); // A, B, C...
            
            // Determine if this row has couple seats
            const hasCouple = includeCouple && i >= displayRows - 2; // Last 2 rows have couple seats if enabled
            
            previewHTML += `<div class="flex items-center justify-center mb-2">
                <div class="w-6 text-sm text-gray-500 text-right mr-2">${rowLabel}</div>
                <div class="flex space-x-1">`;
            
            if (hasCouple) {
                // For couple seats, we show fewer seats that are wider
                const coupleSeatsCount = Math.floor(displaySeats / 2);
                
                for (let j = 0; j < coupleSeatsCount; j++) {
                    previewHTML += `<div class="w-8 h-4 bg-pink-300 rounded-sm text-xs flex items-center justify-center" title="Siège couple">${j+1}</div>`;
                }
            } else {
                // Regular seats
                for (let j = 0; j < displaySeats; j++) {
                    previewHTML += `<div class="w-4 h-4 bg-gray-300 rounded-sm text-xs flex items-center justify-center">${j+1}</div>`;
                }
            }
            
            previewHTML += `</div></div>`;
        }
        
        // Add ellipsis if more rows than we're displaying
        if (rows > displayRows) {
            previewHTML += '<div class="text-center text-gray-500 text-sm">...</div>';
        }
        
        // Update preview
        seatsPreview.innerHTML = previewHTML;
    }
    
    // Event listeners
    rowCountInput.addEventListener('input', function() {
        updateCapacity();
        updateSeatsPreview();
    });
    
    seatsPerRowInput.addEventListener('input', function() {
        updateCapacity();
        updateSeatsPreview();
    });
    
    includeCoupleSeatCheckbox.addEventListener('change', updateSeatsPreview);
    
    // Initialize preview
    updateCapacity();
    updateSeatsPreview();
});
</script>
@endpush