@extends('layouts.app')

@section('title', 'Réservation confirmée - CinéHall')

@section('content')
<div class="bg-gray-100 py-8">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto">
            <!-- Success message -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-6 bg-green-50 border-b border-green-100 text-center">
                    <div class="w-16 h-16 mx-auto flex items-center justify-center rounded-full bg-green-100 mb-4">
                        <i class="fas fa-check text-green-600 text-3xl"></i>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-800 mb-2">Réservation confirmée !</h1>
                    <p class="text-gray-600">
                        Votre paiement a été traité avec succès et votre réservation est confirmée.
                    </p>
                </div>
                
                <!-- Reservation details -->
                <div class="p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Détails de la réservation</h2>
                    
                    <div class="border-b border-gray-200 pb-4 mb-4">
                        <div class="flex flex-col md:flex-row md:justify-between md:items-center">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">{{ $reservation->showtime->movie->title }}</h3>
                                <div class="mt-1 flex items-center flex-wrap">
                                    @if($reservation->showtime->movie->min_age > 0)
                                        <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded mr-2 mb-2">
                                            {{ $reservation->showtime->movie->min_age }}+
                                        </span>
                                    @endif
                                    
                                    <span class="bg-indigo-100 text-indigo-800 text-xs px-2 py-1 rounded mr-2 mb-2">
                                        {{ $reservation->showtime->movie->duration }} min
                                    </span>
                                    
                                    @if($reservation->showtime->movie->genre)
                                        <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded mb-2">
                                            {{ $reservation->showtime->movie->genre }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="mt-4 md:mt-0">
                                <span class="bg-green-100 text-green-800 text-sm px-3 py-1 rounded-full">
                                    Payée
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 mb-2">DÉTAILS DE LA SÉANCE</h3>
                            <div class="space-y-2">
                                <div class="flex items-start">
                                    <i class="fas fa-calendar-alt mt-1 mr-3 text-indigo-600 w-5 text-center"></i>
                                    <div>
                                        <div class="font-medium text-gray-700">Date</div>
                                        <div>{{ \Carbon\Carbon::parse($reservation->showtime->start_time)->locale('fr')->isoFormat('dddd D MMMM YYYY') }}</div>
                                    </div>
                                </div>
                                
                                <div class="flex items-start">
                                    <i class="fas fa-clock mt-1 mr-3 text-indigo-600 w-5 text-center"></i>
                                    <div>
                                        <div class="font-medium text-gray-700">Heure</div>
                                        <div>{{ \Carbon\Carbon::parse($reservation->showtime->start_time)->format('H:i') }}</div>
                                    </div>
                                </div>
                                
                                <div class="flex items-start">
                                    <i class="fas fa-film mt-1 mr-3 text-indigo-600 w-5 text-center"></i>
                                    <div>
                                        <div class="font-medium text-gray-700">Film</div>
                                        <div>{{ $reservation->showtime->movie->title }}</div>
                                    </div>
                                </div>
                                
                                <div class="flex items-start">
                                    <i class="fas fa-map-marker-alt mt-1 mr-3 text-indigo-600 w-5 text-center"></i>
                                    <div>
                                        <div class="font-medium text-gray-700">Salle</div>
                                        <div>{{ $reservation->showtime->theater->name }} ({{ $reservation->showtime->type }})</div>
                                    </div>
                                </div>
                                
                                <div class="flex items-start">
                                    <i class="fas fa-language mt-1 mr-3 text-indigo-600 w-5 text-center"></i>
                                    <div>
                                        <div class="font-medium text-gray-700">Langue</div>
                                        <div>{{ $reservation->showtime->language }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 mb-2">DÉTAILS DE LA RÉSERVATION</h3>
                            <div class="space-y-2">
                                <div class="flex items-start">
                                    <i class="fas fa-ticket-alt mt-1 mr-3 text-indigo-600 w-5 text-center"></i>
                                    <div>
                                        <div class="font-medium text-gray-700">Places réservées</div>
                                        <div>{{ count($reservation->seats) }} {{ count($reservation->seats) > 1 ? 'places' : 'place' }}</div>
                                        <div class="text-sm text-gray-500 mt-1">
                                            @foreach($reservation->seats as $index => $seat)
                                                Rangée {{ $seat->row }}, Siège {{ $seat->number }} {{ $seat->type === 'Couple' ? '(Couple)' : '' }}{{ $index < count($reservation->seats) - 1 ? '<br>' : '' }}
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="flex items-start">
                                    <i class="fas fa-euro-sign mt-1 mr-3 text-indigo-600 w-5 text-center"></i>
                                    <div>
                                        <div class="font-medium text-gray-700">Montant total</div>
                                        <div>{{ number_format($reservation->total_price, 2, ',', ' ') }} €</div>
                                    </div>
                                </div>
                                
                                <div class="flex items-start">
                                    <i class="fas fa-credit-card mt-1 mr-3 text-indigo-600 w-5 text-center"></i>
                                    <div>
                                        <div class="font-medium text-gray-700">Paiement</div>
                                        <div>Carte bancaire •••• 4242</div>
                                    </div>
                                </div>
                                
                                <div class="flex items-start">
                                    <i class="fas fa-receipt mt-1 mr-3 text-indigo-600 w-5 text-center"></i>
                                    <div>
                                        <div class="font-medium text-gray-700">Numéro de réservation</div>
                                        <div>{{ $reservation->id }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Actions -->
                <div class="bg-gray-50 p-6 flex flex-col sm:flex-row justify-between items-center">
                    <div class="text-gray-600 mb-4 sm:mb-0">
                        <p>Vous recevrez votre billet par email dans quelques instants.</p>
                    </div>
                    
                    <div class="flex space-x-3">
                        <a href="{{ route('tickets.show', $reservation->ticket->id) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-md text-sm font-medium transition duration-300">
                            Voir mon billet
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Recommendations -->
            <div class="mt-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Vous pourriez également aimer</h2>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach($recommendedMovies as $movie)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            <a href="{{ route('movies.show', $movie->id) }}" class="block">
                                <div class="h-40 bg-gray-300 overflow-hidden">
                                    @if($movie->image)
                                        <img src="{{ $movie->image }}" alt="{{ $movie->title }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gray-200">
                                            <i class="fas fa-film text-gray-400 text-3xl"></i>
                                        </div>
                                    @endif
                                </div>
                            </a>
                            <div class="p-4">
                                <h3 class="font-medium text-gray-800 mb-1">
                                    <a href="{{ route('movies.show', $movie->id) }}" class="hover:text-indigo-600">
                                        {{ $movie->title }}
                                    </a>
                                </h3>
                                <div class="flex items-center text-xs text-gray-500">
                                    <span>{{ $movie->duration }} min</span>
                                    @if($movie->genre)
                                        <span class="mx-1">•</span>
                                        <span>{{ $movie->genre }}</span>
                                    @endif
                                </div>
                                <div class="mt-3">
                                    <a href="{{ route('showtimes.by-movie', $movie->id) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white py-1 px-3 rounded text-xs inline-block transition duration-300">
                                        Voir les séances
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            
            <!-- Back to home -->
            <div class="mt-8 text-center">
                <a href="{{ route('home') }}" class="text-indigo-600 hover:text-indigo-800 font-medium inline-flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Retour à l'accueil
                </a>
            </div>
        </div>
    </div>
</div>
@endsection