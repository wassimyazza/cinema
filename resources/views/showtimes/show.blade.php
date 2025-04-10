@extends('layouts.app')

@section('title', 'Détails de la séance - CinéHall')

@section('content')
<div class="bg-gray-100 py-8">
    <div class="container mx-auto px-4">
        <!-- Back link -->
        <div class="mb-6">
            <a href="{{ route('showtimes.by-movie', $showtime->movie->id) }}" class="text-indigo-600 hover:text-indigo-800 font-medium flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>
                Retour aux séances de {{ $showtime->movie->title }}
            </a>
        </div>

        <!-- Showtime card -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
            <div class="md:flex">
                <!-- Movie poster -->
                <div class="md:w-1/3 bg-gray-200 md:max-w-xs">
                    @if($showtime->movie->image)
                        <img src="{{ $showtime->movie->image }}" alt="{{ $showtime->movie->title }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full min-h-64 flex items-center justify-center bg-gray-200">
                            <i class="fas fa-film text-gray-400 text-5xl"></i>
                        </div>
                    @endif
                </div>
                
                <!-- Showtime info -->
                <div class="md:w-2/3 p-6">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4">
                        <h1 class="text-2xl font-bold text-gray-800 mb-2 md:mb-0">{{ $showtime->movie->title }}</h1>
                        
                        <div class="flex items-center space-x-2">
                            @if($showtime->movie->min_age > 0)
                                <span class="bg-red-100 text-red-800 text-sm px-3 py-1 rounded-full">
                                    {{ $showtime->movie->min_age }}+
                                </span>
                            @endif
                            
                            <span class="bg-indigo-100 text-indigo-800 text-sm px-3 py-1 rounded-full">
                                {{ $showtime->movie->duration }} min
                            </span>
                        </div>
                    </div>
                    
                    @if($showtime->movie->genre)
                        <div class="mb-4">
                            <span class="bg-blue-100 text-blue-800 text-sm px-3 py-1 rounded-full">
                                {{ $showtime->movie->genre }}
                            </span>
                        </div>
                    @endif
                    
                    <p class="text-gray-600 mb-6 line-clamp-3">
                        {{ Str::limit($showtime->movie->description, 200) }}
                    </p>
                    
                    <div class="border-t border-gray-200 pt-6">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Détails de la séance</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="flex items-start">
                                <i class="fas fa-calendar-alt mt-1 mr-3 text-indigo-600 w-5 text-center"></i>
                                <div>
                                    <div class="font-medium text-gray-700">Date</div>
                                    <div>{{ \Carbon\Carbon::parse($showtime->start_time)->locale('fr')->isoFormat('dddd D MMMM YYYY') }}</div>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <i class="fas fa-clock mt-1 mr-3 text-indigo-600 w-5 text-center"></i>
                                <div>
                                    <div class="font-medium text-gray-700">Heure</div>
                                    <div>{{ \Carbon\Carbon::parse($showtime->start_time)->format('H:i') }}</div>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <i class="fas fa-map-marker-alt mt-1 mr-3 text-indigo-600 w-5 text-center"></i>
                                <div>
                                    <div class="font-medium text-gray-700">Salle</div>
                                    <div>{{ $showtime->theater->name }} ({{ $showtime->theater->capacity }} places)</div>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <i class="fas fa-star mt-1 mr-3 text-indigo-600 w-5 text-center"></i>
                                <div>
                                    <div class="font-medium text-gray-700">Type</div>
                                    <div>{{ $showtime->type }}</div>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <i class="fas fa-language mt-1 mr-3 text-indigo-600 w-5 text-center"></i>
                                <div>
                                    <div class="font-medium text-gray-700">Langue</div>
                                    <div>{{ $showtime->language }}</div>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <i class="fas fa-money-bill-wave mt-1 mr-3 text-indigo-600 w-5 text-center"></i>
                                <div>
                                    <div class="font-medium text-gray-700">Tarif</div>
                                    <div>
                                        {{ $showtime->type == 'VIP' ? '15€ (standard), 25€ (couple)' : '10€ (standard), 18€ (couple)' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-8">
                        <a href="{{ route('reservations.create', $showtime->id) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white py-3 px-6 rounded-lg font-bold transition duration-300">
                            Réserver des places
                        </a>
                        
                        <a href="{{ route('movies.show', $showtime->movie->id) }}" class="ml-4 inline-flex items-center text-indigo-600 hover:text-indigo-800 font-medium">
                            <i class="fas fa-info-circle mr-2"></i>
                            Plus d'infos sur le film
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Warning if session expired -->
        @if(request()->has('expired') && request()->expired == 'true')
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                <strong class="font-bold">Réservation expirée!</strong>
                <span class="block sm:inline">Votre réservation a expiré car le temps alloué pour le paiement s'est écoulé. Veuillez sélectionner à nouveau vos places.</span>
                <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3 alert-close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        <!-- Other showtimes for the same movie -->
        <div>
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Autres séances pour ce film</h2>
            
            @if(count($otherShowtimes) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($otherShowtimes as $otherShowtime)
                        <div class="bg-white p-4 rounded-lg shadow-md">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <div class="text-lg font-semibold text-gray-800">
                                        {{ \Carbon\Carbon::parse($otherShowtime->start_time)->locale('fr')->isoFormat('dddd D MMMM') }}
                                    </div>
                                    <div class="text-indigo-600 font-bold">
                                        {{ \Carbon\Carbon::parse($otherShowtime->start_time)->format('H:i') }}
                                    </div>
                                </div>
                                <span class="px-2 py-1 rounded-full text-xs font-medium {{ $otherShowtime->type == 'VIP' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800' }}">
                                    {{ $otherShowtime->type }}
                                </span>
                            </div>
                            
                            <div class="text-sm text-gray-600 mb-4">
                                <div>{{ $otherShowtime->theater->name }}</div>
                                <div>{{ $otherShowtime->language }}</div>
                            </div>
                            
                            <a href="{{ route('reservations.create', $otherShowtime->id) }}" class="w-full block text-center bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded text-sm font-medium transition duration-300">
                                Réserver
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-lg shadow-md p-6 text-center">
                    <p class="text-gray-600">Aucune autre séance disponible pour ce film.</p>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Alert close button
    document.addEventListener('DOMContentLoaded', function() {
        const alertCloseBtn = document.querySelector('.alert-close');
        if (alertCloseBtn) {
            alertCloseBtn.addEventListener('click', function() {
                this.parentElement.remove();
            });
        }
    });
</script>
@endpush
@endsection