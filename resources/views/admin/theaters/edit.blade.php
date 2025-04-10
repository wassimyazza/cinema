@extends('layouts.admin')

@section('title', 'Modifier la salle - Administration CinéHall')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
        <div class="lg:flex lg:items-center lg:justify-between mb-6">
            <div class="flex-1 min-w-0">
                <h1 class="text-2xl font-semibold text-gray-900">Modifier la salle</h1>
                <p class="mt-1 text-sm text-gray-500">
                    Modifier les informations de la salle "{{ $theater->name }}"
                </p>
            </div>
            <div class="mt-5 flex lg:mt-0 lg:ml-4">
                <a href="{{ route('admin.theaters.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Retour à la liste
                </a>
                
                <a href="{{ route('admin.seats.index') }}?theater={{ $theater->id }}" class="ml-3 inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <i class="fas fa-chair mr-2"></i>
                    Gérer les sièges
                </a>
            </div>
        </div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
        <form action="{{ route('admin.theaters.update', $theater->id) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')
            
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Informations de la salle
                    </h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">
                        Détails de la salle
                    </p>
                </div>
                <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        <div class="sm:col-span-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Nom de la salle</label>
                            <div class="mt-1">
                                <input type="text" name="name" id="name" value="{{ old('name', $theater->name) }}" required class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                            @error('name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-2 text-sm text-gray-500">Le nom doit être unique et identifiable facilement</p>
                        </div>
                        
                        <div class="sm:col-span-3">
                            <label for="capacity" class="block text-sm font-medium text-gray-700">Capacité (places)</label>
                            <div class="mt-1">
                                <input type="number" name="capacity" id="capacity" value="{{ old('capacity', $theater->capacity) }}" min="1" required class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
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
                                    <option value="Normal" {{ old('type', $theater->type) == 'Normal' ? 'selected' : '' }}>Normal</option>
                                    <option value="VIP" {{ old('type', $theater->type) == 'VIP' ? 'selected' : '' }}>VIP</option>
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
                        Informations sur les sièges
                    </h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">
                        Récapitulatif des sièges dans cette salle
                    </p>
                </div>
                <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                    <div class="mb-4">
                        <div class="text-sm text-gray-600">
                            <p>Cette salle dispose actuellement de <span class="font-semibold">{{ $theater->seats_count ?? 0 }}</span> sièges configurés.</p>
                            <p class="mt-1">Vous pouvez modifier la disposition des sièges depuis la page de <a href="{{ route('admin.seats.index') }}?theater={{ $theater->id }}" class="text-indigo-600 hover:text-indigo-500">gestion des sièges</a>.</p>
                        </div>
                    </div>
                    
                    <div class="mt-4 bg-gray-50 p-4 rounded-md">
                        <div class="mb-4 w-3/4 mx-auto">
                            <div class="h-4 bg-indigo-200 rounded text-center text-xs text-indigo-800 leading-4">ÉCRAN</div>
                        </div>
                        
                        <div id="seats-preview" class="mt-6 overflow-auto" style="max-height: 300px;">
                            @if(($theater->seats_count ?? 0) > 0)
                                <!-- Mini preview of seat layout will be shown here -->
                                <div class="text-center">
                                    @php
                                        $seats = $theater->seats ?? collect([]);
                                        $rows = $seats->pluck('row')->unique()->sort()->values();
                                    @endphp
                                    
                                    @foreach($rows as $row)
                                        <div class="flex items-center justify-center mb-2">
                                            <div class="w-6 text-sm text-gray-500 text-right mr-2">{{ $row }}</div>
                                            <div class="flex space-x-1">
                                                @php
                                                    $rowSeats = $seats->where('row', $row)->sortBy('number');
                                                @endphp
                                                
                                                @foreach($rowSeats as $seat)
                                                    <div class="w-{{ $seat->type == 'Couple' ? '8' : '4' }} h-4 bg-{{ $seat->type == 'Couple' ? 'pink' : 'gray' }}-300 rounded-sm text-xs flex items-center justify-center" title="{{ $seat->type == 'Couple' ? 'Siège couple' : 'Siège standard' }}">
                                                        {{ $seat->number }}
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center text-gray-500">
                                    <p>Aucun siège n'a encore été configuré pour cette salle.</p>
                                    <p class="mt-2">Utilisez la page de gestion des sièges pour ajouter des sièges.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Séances programmées
                    </h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">
                        Cette salle est utilisée dans les séances suivantes
                    </p>
                </div>
                <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                    @if($theater->showtimes_count > 0)
                        <div class="text-sm text-gray-600 mb-4">
                            <p>Cette salle est utilisée pour <span class="font-semibold">{{ $theater->showtimes_count }}</span> séances.</p>
                            <p class="mt-1">La modification des informations de la salle n'affectera pas les séances existantes.</p>
                        </div>
                        
                        <a href="{{ route('admin.showtimes.index') }}?theater={{ $theater->id }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <i class="fas fa-calendar-alt mr-2"></i>
                            Voir les séances dans cette salle
                        </a>
                    @else
                        <div class="text-sm text-gray-600">
                            <p>Aucune séance n'est actuellement programmée dans cette salle.</p>
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="flex justify-end">
                <a href="{{ route('admin.theaters.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Annuler
                </a>
                <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Mettre à jour la salle
                </button>
            </div>
        </form>
    </div>
</div>
@endsection