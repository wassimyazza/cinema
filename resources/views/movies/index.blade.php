@extends('layouts.app')

@section('title', 'Films à l\'affiche - CinéHall')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-col md:flex-row justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-4 md:mb-0">Films à l'affiche</h1>
            
            <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-4">
                <!-- Search bar -->
                <div class="relative">
                    <input type="text" id="movie-search" placeholder="Rechercher un film..." 
                        class="border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 w-full sm:w-64">
                    <button class="absolute right-3 top-2 text-gray-500">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                
                <!-- Filter dropdown -->
                <div class="relative inline-block text-left">
                    <button id="filter-dropdown" type="button" class="inline-flex justify-center w-full rounded-lg border border-gray-300 px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        Filtrer par genre
                        <i class="fas fa-chevron-down ml-2 mt-1"></i>
                    </button>
                    <div id="filter-menu" class="hidden origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-10">
                        <div class="py-1">
                            <a href="#" class="genre-filter block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" data-genre="all">Tous les genres</a>
                            <a href="#" class="genre-filter block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" data-genre="Action">Action</a>
                            <a href="#" class="genre-filter block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" data-genre="Comédie">Comédie</a>
                            <a href="#" class="genre-filter block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" data-genre="Drame">Drame</a>
                            <a href="#" class="genre-filter block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" data-genre="Science-Fiction">Science-Fiction</a>
                            <a href="#" class="genre-filter block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" data-genre="Horreur">Horreur</a>
                            <a href="#" class="genre-filter block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" data-genre="Animation">Animation</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Active filters -->
        <div id="active-filters" class="mb-6 hidden">
            <div class="flex items-center">
                <span class="text-gray-600 mr-2">Filtres actifs:</span>
                <div id="filter-tags" class="flex flex-wrap gap-2">
                    <!-- Filter tags will be added here dynamically -->
                </div>
                <button id="clear-filters" class="ml-4 text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                    Effacer tous les filtres
                </button>
            </div>
        </div>
        
        <!-- Movie grid -->
        <div id="movie-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($movies as $movie)
                <div class="bg-white rounded-lg shadow-md overflow-hidden movie-card" data-genre="{{ $movie->genre }}">
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
                            <h2 class="text-lg font-semibold text-gray-800">
                                <a href="{{ route('movies.show', $movie->id) }}" class="hover:text-indigo-600">
                                    {{ $movie->title }}
                                </a>
                            </h2>
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
                                <span class="genre-tag">{{ $movie->genre }}</span>
                            @endif
                        </div>
                        
                        <p class="mt-2 text-sm text-gray-600 line-clamp-2">
                            {{ Str::limit($movie->description, 100) }}
                        </p>
                        
                        <div class="mt-4 flex space-x-2">
                            <a href="{{ route('movies.show', $movie->id) }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 py-2 px-4 rounded text-sm inline-block transition duration-300">
                                Détails
                            </a>
                            <a href="{{ route('showtimes.by-movie', $movie->id) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded text-sm inline-block transition duration-300">
                                Réserver
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12 bg-white rounded-lg shadow-md">
                    <i class="fas fa-film text-gray-400 text-5xl mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">Aucun film trouvé</h3>
                    <p class="text-gray-500">Aucun film ne correspond à vos critères de recherche.</p>
                    <button id="reset-search" class="mt-4 bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-6 rounded transition duration-300">
                        Réinitialiser la recherche
                    </button>
                </div>
            @endforelse
        </div>
        
        <!-- Pagination -->
        @if($movies->hasPages())
            <div class="mt-8">
                {{ $movies->links() }}
            </div>
        @endif
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle filter dropdown
        const filterDropdown = document.getElementById('filter-dropdown');
        const filterMenu = document.getElementById('filter-menu');
        
        filterDropdown.addEventListener('click', function() {
            filterMenu.classList.toggle('hidden');
        });
        
        // Close the dropdown when clicking outside
        document.addEventListener('click', function(event) {
            if (!filterDropdown.contains(event.target) && !filterMenu.contains(event.target)) {
                filterMenu.classList.add('hidden');
            }
        });
        
        // Search functionality
        const searchInput = document.getElementById('movie-search');
        const movieCards = document.querySelectorAll('.movie-card');
        const movieGrid = document.getElementById('movie-grid');
        const resetSearch = document.getElementById('reset-search');
        
        searchInput.addEventListener('input', filterMovies);
        
        if (resetSearch) {
            resetSearch.addEventListener('click', function() {
                searchInput.value = '';
                filterMovies();
                document.querySelectorAll('.genre-filter').forEach(filter => {
                    filter.classList.remove('bg-indigo-100');
                });
                document.getElementById('active-filters').classList.add('hidden');
                document.getElementById('filter-tags').innerHTML = '';
                showAllMovies();
            });
        }
        
        // Genre filtering
        const genreFilters = document.querySelectorAll('.genre-filter');
        const activeFilters = document.getElementById('active-filters');
        const filterTags = document.getElementById('filter-tags');
        const clearFilters = document.getElementById('clear-filters');
        
        genreFilters.forEach(filter => {
            filter.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Clear other selections
                genreFilters.forEach(f => f.classList.remove('bg-indigo-100'));
                this.classList.add('bg-indigo-100');
                
                const genre = this.dataset.genre;
                filterByGenre(genre);
                
                // Show active filter
                if (genre !== 'all') {
                    activeFilters.classList.remove('hidden');
                    filterTags.innerHTML = `
                        <span class="bg-indigo-100 text-indigo-800 text-sm px-3 py-1 rounded-full flex items-center">
                            Genre: ${genre}
                            <button class="ml-2 text-indigo-600 hover:text-indigo-800" data-remove="genre">
                                <i class="fas fa-times"></i>
                            </button>
                        </span>
                    `;
                    
                    // Add event listener to remove button
                    const removeBtn = filterTags.querySelector('[data-remove="genre"]');
                    if (removeBtn) {
                        removeBtn.addEventListener('click', function() {
                            activeFilters.classList.add('hidden');
                            filterTags.innerHTML = '';
                            showAllMovies();
                            genreFilters.forEach(f => f.classList.remove('bg-indigo-100'));
                            filterMenu.classList.add('hidden');
                        });
                    }
                } else {
                    activeFilters.classList.add('hidden');
                    filterTags.innerHTML = '';
                }
                
                filterMenu.classList.add('hidden');
            });
        });
        
        if (clearFilters) {
            clearFilters.addEventListener('click', function() {
                activeFilters.classList.add('hidden');
                filterTags.innerHTML = '';
                showAllMovies();
                genreFilters.forEach(f => f.classList.remove('bg-indigo-100'));
                searchInput.value = '';
            });
        }
        
        function filterMovies() {
            const searchTerm = searchInput.value.toLowerCase();
            let foundMovies = false;
            
            movieCards.forEach(card => {
                const title = card.querySelector('h2').textContent.toLowerCase();
                const genre = card.dataset.genre ? card.dataset.genre.toLowerCase() : '';
                const description = card.querySelector('p') ? card.querySelector('p').textContent.toLowerCase() : '';
                
                if (title.includes(searchTerm) || genre.includes(searchTerm) || description.includes(searchTerm)) {
                    card.classList.remove('hidden');
                    foundMovies = true;
                } else {
                    card.classList.add('hidden');
                }
            });
            
            // Show "no movies found" message if needed
            checkNoMoviesFound(foundMovies);
        }
        
        function filterByGenre(genre) {
            let foundMovies = false;
            
            if (genre === 'all') {
                showAllMovies();
                return;
            }
            
            movieCards.forEach(card => {
                const cardGenre = card.dataset.genre;
                if (cardGenre === genre) {
                    card.classList.remove('hidden');
                    foundMovies = true;
                } else {
                    card.classList.add('hidden');
                }
            });
            
            // Show "no movies found" message if needed
            checkNoMoviesFound(foundMovies);
        }
        
        function showAllMovies() {
            movieCards.forEach(card => {
                card.classList.remove('hidden');
            });
            
            // Remove "no movies found" message
            const noMoviesMessage = document.querySelector('.no-movies-message');
            if (noMoviesMessage) {
                noMoviesMessage.remove();
            }
        }
        
        function checkNoMoviesFound(foundMovies) {
            // Remove existing message
            const existingMessage = document.querySelector('.no-movies-message');
            if (existingMessage) {
                existingMessage.remove();
            }
            
            // Add message if no movies found
            if (!foundMovies) {
                const noMoviesMessage = document.createElement('div');
                noMoviesMessage.className = 'col-span-full text-center py-12 bg-white rounded-lg shadow-md no-movies-message';
                noMoviesMessage.innerHTML = `
                    <i class="fas fa-search text-gray-400 text-5xl mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">Aucun film trouvé</h3>
                    <p class="text-gray-500">Aucun film ne correspond à vos critères de recherche.</p>
                    <button id="reset-search-inline" class="mt-4 bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-6 rounded transition duration-300">
                        Réinitialiser la recherche
                    </button>
                `;
                
                movieGrid.appendChild(noMoviesMessage);
                
                // Add event listener to the reset button
                document.getElementById('reset-search-inline').addEventListener('click', function() {
                    searchInput.value = '';
                    filterMovies();
                    document.querySelectorAll('.genre-filter').forEach(filter => {
                        filter.classList.remove('bg-indigo-100');
                    });
                    document.getElementById('active-filters').classList.add('hidden');
                    document.getElementById('filter-tags').innerHTML = '';
                    showAllMovies();
                });
            }
        }
    });
</script>
@endpush