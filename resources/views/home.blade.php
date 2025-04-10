@extends('layouts.app')

@section('title', 'CinéHall - Votre cinéma en ligne')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section text-white py-20">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Bienvenue à CinéHall</h1>
            <p class="text-xl mb-8">Réservez vos places de cinéma en ligne et vivez une expérience unique</p>
            <div class="space-x-4">
                <a href="{{ route('movies.index') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300">
                    Voir les films
                </a>
                <a href="{{ route('showtimes.index') }}" class="bg-transparent hover:bg-white hover:text-indigo-900 text-white font-bold py-3 px-6 rounded-lg border border-white transition duration-300">
                    Réserver maintenant
                </a>
            </div>
        </div>
    </section>
    
    <!-- Popular Movies Section -->
    <section class="py-12 bg-white">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800">Films populaires</h2>
                <a href="{{ route('movies.index') }}" class="text-indigo-600 hover:text-indigo-800 font-semibold">Voir tous les films</a>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($popularMovies as $movie)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden movie-card">
                        <a href="{{ route('movies.show', $movie->id) }}" class="block">
                            <div class="h-64 bg-gray-300 overflow-hidden">
                                @if($movie->image)
                                    <img src="{{ $movie->image }}" alt="{{ $movie->title }}" class="w-full h-full object-cover movie-poster">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gray-200">
                                        <i class="fas fa-film text-gray-400 text-5xl"></i>
                                    </div>
                                @endif
                            </div>
                        </a>
                        <div class="p-4">
                            <div class="flex justify-between items-start">
                                <h3 class="text-lg font-semibold text-gray-800">
                                    <a href="{{ route('movies.show', $movie->id) }}" class="hover:text-indigo-600">
                                        {{ $movie->title }}
                                    </a>
                                </h3>
                                <span class="bg-indigo-100 text-indigo-800 text-xs px-2 py-1 rounded">
                                    {{ $movie->duration }} min
                                </span>
                            </div>
                            
                            <div class="flex items-center mt-2 text-sm text-gray-600">
                                @if($movie->min_age > 0)
                                    <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded mr-2">
                                        {{ $movie->min_age }}+
                                    </span>
                                @endif
                                @if($movie->genre)
                                    <span>{{ $movie->genre }}</span>
                                @endif
                            </div>
                            
                            <div class="mt-4">
                                <a href="{{ route('showtimes.by-movie', $movie->id) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded text-sm inline-block transition duration-300">
                                    Réserver
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-8 text-gray-500">
                        <i class="fas fa-film text-gray-400 text-5xl mb-4"></i>
                        <p>Aucun film disponible pour le moment</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
    
    <!-- Upcoming Showtimes Section -->
    <section class="py-12 bg-gray-100">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800">Séances à venir</h2>
                <a href="{{ route('showtimes.index') }}" class="text-indigo-600 hover:text-indigo-800 font-semibold">Voir toutes les séances</a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($upcomingShowtimes as $showtime)
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-lg font-semibold text-gray-800">
                                <a href="{{ route('movies.show', $showtime->movie->id) }}" class="hover:text-indigo-600">
                                    {{ $showtime->movie->title }}
                                </a>
                            </h3>
                            <span class="bg-{{ $showtime->type == 'VIP' ? 'yellow-100 text-yellow-800' : 'blue-100 text-blue-800' }} text-xs px-2 py-1 rounded">
                                {{ $showtime->type }}
                            </span>
                        </div>
                        
                        <div class="mb-4">
                            <div class="flex items-center mb-2 text-gray-600">
                                <i class="fas fa-calendar-alt mr-2"></i>
                                <span>{{ \Carbon\Carbon::parse($showtime->start_time)->format('d/m/Y') }}</span>
                            </div>
                            <div class="flex items-center mb-2 text-gray-600">
                                <i class="fas fa-clock mr-2"></i>
                                <span>{{ \Carbon\Carbon::parse($showtime->start_time)->format('H:i') }}</span>
                            </div>
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-map-marker-alt mr-2"></i>
                                <span>{{ $showtime->theater->name }}</span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="text-sm text-gray-500">{{ $showtime->language }}</span>
                            </div>
                            <a href="{{ route('reservations.create', $showtime->id) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded text-sm transition duration-300">
                                Réserver
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-8 text-gray-500">
                        <i class="fas fa-calendar-times text-gray-400 text-5xl mb-4"></i>
                        <p>Aucune séance disponible pour le moment</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
    
    <!-- Features Section -->
    <section class="py-12 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-gray-800 text-center mb-12">Pourquoi choisir CinéHall?</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="bg-indigo-100 w-20 h-20 mx-auto rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-ticket-alt text-indigo-600 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Réservation facile</h3>
                    <p class="text-gray-600">Réservez vos places en quelques clics, sans vous déplacer.</p>
                </div>
                
                <div class="text-center">
                    <div class="bg-indigo-100 w-20 h-20 mx-auto rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-couch text-indigo-600 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Choix de sièges</h3>
                    <p class="text-gray-600">Sélectionnez vos places préférées avec notre système interactif.</p>
                </div>
                
                <div class="text-center">
                    <div class="bg-indigo-100 w-20 h-20 mx-auto rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-qrcode text-indigo-600 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Billets électroniques</h3>
                    <p class="text-gray-600">Recevez vos billets avec QR code directement sur votre téléphone.</p>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    // Any additional JavaScript for the home page
    document.addEventListener('DOMContentLoaded', function() {
        // Animation for movie cards if needed
        const movieCards = document.querySelectorAll('.movie-card');
        movieCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.classList.add('shadow-lg');
            });
            
            card.addEventListener('mouseleave', function() {
                this.classList.remove('shadow-lg');
            });
        });
    });
</script>
@endpush