@extends('layouts.app')

@section('title', $movie->title . ' - CinéHall')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Movie details section -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="md:flex">
                <!-- Movie poster -->
                <div class="md:w-1/3 bg-gray-200">
                    @if($movie->image)
                        <img src="{{ $movie->image }}" alt="{{ $movie->title }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full min-h-64 flex items-center justify-center bg-gray-200">
                            <i class="fas fa-film text-gray-400 text-5xl"></i>
                        </div>
                    @endif
                </div>
                
                <!-- Movie info -->
                <div class="md:w-2/3 p-6">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4">
                        <h1 class="text-3xl font-bold text-gray-900 mb-2 md:mb-0">{{ $movie->title }}</h1>
                        
                        <div class="flex items-center">
                            @if($movie->min_age > 0)
                                <span class="bg-red-100 text-red-800 text-sm px-3 py-1 rounded-full mr-2">
                                    {{ $movie->min_age }}+
                                </span>
                            @endif
                            
                            <span class="bg-indigo-100 text-indigo-800 text-sm px-3 py-1 rounded-full">
                                {{ $movie->duration }} minutes
                            </span>
                        </div>
                    </div>
                    
                    @if($movie->genre)
                        <div class="mb-4">
                            <span class="bg-blue-100 text-blue-800 text-sm px-3 py-1 rounded-full">
                                {{ $movie->genre }}
                            </span>
                        </div>
                    @endif
                    
                    <div class="prose max-w-none text-gray-700 mb-6">
                        <p>{{ $movie->description }}</p>
                    </div>
                    
                    <div class="mt-8">
                        <a href="{{ route('showtimes.by-movie', $movie->id) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white py-3 px-6 rounded-lg font-bold transition duration-300">
                            Voir les séances
                        </a>
                        
                        @if($movie->trailer_url)
                            <button id="watch-trailer" class="ml-4 bg-transparent hover:bg-indigo-50 text-indigo-600 py-3 px-6 rounded-lg font-bold border border-indigo-600 transition duration-300">
                                <i class="fas fa-play mr-2"></i> Voir la bande-annonce
                            </button>
                        @endif
                    </div>
                </div>
            </div>
            
            @if($movie->trailer_url)
                <!-- Trailer section (hidden by default) -->
                <div id="trailer-section" class="hidden p-6 border-t border-gray-200">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Bande-annonce</h2>
                    <div class="aspect-w-16 aspect-h-9">
                        <iframe id="trailer-iframe" width="100%" height="450" src="" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                </div>
            @endif
        </div>
        
        <!-- Upcoming showtimes section -->
        <div class="mt-10">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Prochaines séances</h2>
            
            @if(count($upcomingShowtimes) > 0)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Heure
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Salle
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Type
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Langue
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($upcomingShowtimes as $showtime)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ \Carbon\Carbon::parse($showtime->start_time)->format('d/m/Y') }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ \Carbon\Carbon::parse($showtime->start_time)->format('H:i') }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ $showtime->theater->name }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $showtime->type == 'VIP' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800' }}">
                                                {{ $showtime->type }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ $showtime->language }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('reservations.create', $showtime->id) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded text-xs transition duration-300">
                                                Réserver
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="mt-4 text-center">
                    <a href="{{ route('showtimes.by-movie', $movie->id) }}" class="text-indigo-600 hover:text-indigo-800 font-medium inline-flex items-center">
                        Voir toutes les séances
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            @else
                <div class="bg-white rounded-lg shadow-md p-8 text-center">
                    <i class="fas fa-calendar-times text-gray-400 text-4xl mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">Aucune séance disponible</h3>
                    <p class="text-gray-500">Il n'y a pas de séances à venir pour ce film.</p>
                </div>
            @endif
        </div>
    </div>
    
    @if($movie->trailer_url)
        <!-- Trailer modal (fixed position) -->
        <div id="trailer-modal" class="fixed inset-0 bg-black bg-opacity-75 hidden flex items-center justify-center z-50">
            <div class="relative w-full max-w-4xl mx-4">
                <button id="close-trailer" class="absolute -top-10 right-0 text-white hover:text-gray-300">
                    <i class="fas fa-times text-2xl"></i>
                </button>
                
                <div class="aspect-w-16 aspect-h-9 bg-black">
                    <iframe id="modal-trailer-iframe" width="100%" height="100%" src="" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Trailer functionality
        @if($movie->trailer_url)
            const trailerUrl = "{{ $movie->trailer_url }}";
            const trailerButton = document.getElementById('watch-trailer');
            const trailerModal = document.getElementById('trailer-modal');
            const modalIframe = document.getElementById('modal-trailer-iframe');
            const closeButton = document.getElementById('close-trailer');
            
            // Function to extract YouTube ID
            function getYouTubeId(url) {
                const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=)([^#&?]*).*/;
                const match = url.match(regExp);
                return (match && match[2].length === 11) ? match[2] : null;
            }
            
            // Function to create YouTube embed URL
            function getYouTubeEmbedUrl(id) {
                return `https://www.youtube.com/embed/${id}`;
            }
            
            const youtubeId = getYouTubeId(trailerUrl);
            if (youtubeId) {
                const embedUrl = getYouTubeEmbedUrl(youtubeId);
                
                trailerButton.addEventListener('click', function() {
                    modalIframe.src = embedUrl;
                    trailerModal.classList.remove('hidden');
                    document.body.classList.add('overflow-hidden');
                });
                
                closeButton.addEventListener('click', function() {
                    modalIframe.src = '';
                    trailerModal.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                });
                
                // Close modal when clicking outside
                trailerModal.addEventListener('click', function(e) {
                                            if (e.target === trailerModal) {
                        modalIframe.src = '';
                        trailerModal.classList.add('hidden');
                        document.body.classList.remove('overflow-hidden');
                    }
                });
                
                // Close modal with escape key
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape' && !trailerModal.classList.contains('hidden')) {
                        modalIframe.src = '';
                        trailerModal.classList.add('hidden');
                        document.body.classList.remove('overflow-hidden');
                    }
                });
            }
        @endif
    });
</script>
@endpush