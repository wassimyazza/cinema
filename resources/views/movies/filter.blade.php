<!-- Movie Filter Component -->
<div class="bg-white rounded-lg shadow-md p-6 mb-8">
    <h2 class="text-lg font-medium text-gray-800 mb-4">Filtrer les films</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Search -->
        <div>
            <label for="movie-search" class="block text-sm font-medium text-gray-700 mb-1">Rechercher</label>
            <div class="mt-1 relative rounded-md shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="text" id="movie-search" placeholder="Titre du film..." 
                    class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    value="{{ request('search') }}">
            </div>
        </div>
        
        <!-- Genre filter -->
        <div>
            <label for="genre-filter" class="block text-sm font-medium text-gray-700 mb-1">Genre</label>
            <select id="genre-filter" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                <option value="">Tous les genres</option>
                @foreach($genres as $genre)
                    <option value="{{ $genre }}" {{ request('genre') == $genre ? 'selected' : '' }}>{{ $genre }}</option>
                @endforeach
            </select>
        </div>
        
        <!-- Age rating filter -->
        <div>
            <label for="age-filter" class="block text-sm font-medium text-gray-700 mb-1">Classification</label>
            <select id="age-filter" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                <option value="">Toutes les classifications</option>
                <option value="0" {{ request('min_age') == '0' ? 'selected' : '' }}>Tous publics</option>
                <option value="10" {{ request('min_age') == '10' ? 'selected' : '' }}>10+ ans</option>
                <option value="12" {{ request('min_age') == '12' ? 'selected' : '' }}>12+ ans</option>
                <option value="16" {{ request('min_age') == '16' ? 'selected' : '' }}>16+ ans</option>
                <option value="18" {{ request('min_age') == '18' ? 'selected' : '' }}>18+ ans</option>
            </select>
        </div>
    </div>
    
    <!-- Sort and filter actions -->
    <div class="mt-4 flex flex-col sm:flex-row sm:justify-between sm:items-center space-y-3 sm:space-y-0">
        <div>
            <label for="sort-filter" class="block text-sm font-medium text-gray-700 mb-1 sm:inline sm:mr-2">Trier par</label>
            <select id="sort-filter" class="inline-block w-full sm:w-auto pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Plus récents</option>
                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Plus anciens</option>
                <option value="title_asc" {{ request('sort') == 'title_asc' ? 'selected' : '' }}>Titre (A-Z)</option>
                <option value="title_desc" {{ request('sort') == 'title_desc' ? 'selected' : '' }}>Titre (Z-A)</option>
                <option value="duration_asc" {{ request('sort') == 'duration_asc' ? 'selected' : '' }}>Durée (croissante)</option>
                <option value="duration_desc" {{ request('sort') == 'duration_desc' ? 'selected' : '' }}>Durée (décroissante)</option>
            </select>
        </div>
        
        <div class="flex space-x-3">
            <button id="apply-filters" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <i class="fas fa-filter mr-2"></i>
                Appliquer les filtres
            </button>
            
            <button id="clear-filters" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <i class="fas fa-times mr-2"></i>
                Effacer
            </button>
        </div>
    </div>
    
    <!-- Active filters -->
    <div id="active-filters" class="mt-4 {{ empty(request()->except('page')) ? 'hidden' : '' }}">
        <div class="flex flex-wrap items-center gap-2">
            <span class="text-sm text-gray-600">Filtres actifs:</span>
            <div id="filter-tags" class="flex flex-wrap gap-2">
                @if(request('search'))
                    <span class="bg-indigo-100 text-indigo-800 text-sm px-3 py-1 rounded-full flex items-center">
                        Recherche: {{ request('search') }}
                        <button class="ml-2 text-indigo-600 hover:text-indigo-800" data-filter="search">
                            <i class="fas fa-times"></i>
                        </button>
                    </span>
                @endif
                
                @if(request('genre'))
                    <span class="bg-indigo-100 text-indigo-800 text-sm px-3 py-1 rounded-full flex items-center">
                        Genre: {{ request('genre') }}
                        <button class="ml-2 text-indigo-600 hover:text-indigo-800" data-filter="genre">
                            <i class="fas fa-times"></i>
                        </button>
                    </span>
                @endif
                
                @if(request('min_age'))
                    <span class="bg-indigo-100 text-indigo-800 text-sm px-3 py-1 rounded-full flex items-center">
                        Âge: {{ request('min_age') == '0' ? 'Tous publics' : request('min_age').'+ ans' }}
                        <button class="ml-2 text-indigo-600 hover:text-indigo-800" data-filter="min_age">
                            <i class="fas fa-times"></i>
                        </button>
                    </span>
                @endif
                
                @if(request('sort'))
                    <span class="bg-indigo-100 text-indigo-800 text-sm px-3 py-1 rounded-full flex items-center">
                        Tri: {{ [
                            'newest' => 'Plus récents',
                            'oldest' => 'Plus anciens',
                            'title_asc' => 'Titre (A-Z)',
                            'title_desc' => 'Titre (Z-A)',
                            'duration_asc' => 'Durée (croissante)',
                            'duration_desc' => 'Durée (décroissante)'
                        ][request('sort')] }}
                        <button class="ml-2 text-indigo-600 hover:text-indigo-800" data-filter="sort">
                            <i class="fas fa-times"></i>
                        </button>
                    </span>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for filter functionality -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('movie-search');
        const genreFilter = document.getElementById('genre-filter');
        const ageFilter = document.getElementById('age-filter');
        const sortFilter = document.getElementById('sort-filter');
        const applyFiltersBtn = document.getElementById('apply-filters');
        const clearFiltersBtn = document.getElementById('clear-filters');
        const activeFilters = document.getElementById('active-filters');
        const filterTags = document.getElementById('filter-tags');
        
        // Apply filters
        applyFiltersBtn.addEventListener('click', function() {
            applyFilters();
        });
        
        // Clear all filters
        clearFiltersBtn.addEventListener('click', function() {
            searchInput.value = '';
            genreFilter.value = '';
            ageFilter.value = '';
            sortFilter.value = 'newest';
            applyFilters();
        });
        
        // Individual filter removal
        document.querySelectorAll('[data-filter]').forEach(button => {
            button.addEventListener('click', function() {
                const filter = this.dataset.filter;
                
                if (filter === 'search') {
                    searchInput.value = '';
                } else if (filter === 'genre') {
                    genreFilter.value = '';
                } else if (filter === 'min_age') {
                    ageFilter.value = '';
                } else if (filter === 'sort') {
                    sortFilter.value = 'newest';
                }
                
                applyFilters();
            });
        });
        
        // Apply filters and navigate
        function applyFilters() {
            const params = new URLSearchParams();
            
            if (searchInput.value) {
                params.append('search', searchInput.value);
            }
            
            if (genreFilter.value) {
                params.append('genre', genreFilter.value);
            }
            
            if (ageFilter.value) {
                params.append('min_age', ageFilter.value);
            }
            
            if (sortFilter.value && sortFilter.value !== 'newest') {
                params.append('sort', sortFilter.value);
            }
            
            // Keep the page parameter if it exists
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('page') && params.toString()) {
                params.append('page', urlParams.get('page'));
            }
            
            // Navigate to the filtered URL
            const paramsString = params.toString() ? `?${params.toString()}` : '';
            window.location.href = window.location.pathname + paramsString;
        }
        
        // Submit on enter key in search
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                applyFilters();
            }
        });
    });
</script>