@extends('layouts.app')

@section('title', 'Séances - CinéHall')

@section('content')
<div class="bg-gray-100 py-8">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Séances disponibles</h1>
        
        <!-- Filters -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0">
                <div class="flex items-center space-x-4">
                    <div>
                        <label for="date-filter" class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                        <select id="date-filter" class="block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="all">Toutes les dates</option>
                            <option value="today" selected>Aujourd'hui</option>
                            <option value="tomorrow">Demain</option>
                            <option value="week">Cette semaine</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="type-filter" class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                        <select id="type-filter" class="block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="all">Tous les types</option>
                            <option value="Normal">Normal</option>
                            <option value="VIP">VIP</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="language-filter" class="block text-sm font-medium text-gray-700 mb-1">Langue</label>
                        <select id="language-filter" class="block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="all">Toutes les langues</option>
                            <option value="Français">Français</option>
                            <option value="Anglais">Anglais (VOST)</option>
                        </select>
                    </div>
                </div>
                
                <div class="relative">
                    <label for="movie-search" class="block text-sm font-medium text-gray-700 mb-1">Rechercher un film</label>
                    <input type="text" id="movie-search" placeholder="Titre du film..." 
                        class="block w-full py-2 pl-10 pr-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none" style="top: 24px;">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Date navigation -->
        <div class="flex overflow-x-auto py-4 mb-6 scrollbar-hide">
            <div class="flex space-x-2">
                @php
                    $today = \Carbon\Carbon::now();
                    $dates = [];
                    for ($i = 0; $i < 14; $i++) {
                        $date = $today->copy()->addDays($i);
                        $dates[] = $date;
                    }
                @endphp
                
                @foreach($dates as $index => $date)
                    <button class="date-button flex flex-col items-center justify-center min-w-20 py-2 px-4 rounded-lg {{ $index === 0 ? 'bg-indigo-600 text-white' : 'bg-white text-gray-800 hover:bg-gray-50' }}" data-date="{{ $date->format('Y-m-d') }}">
                        <span class="text-xs font-medium {{ $index === 0 ? 'text-indigo-200' : 'text-gray-500' }}">
                            {{ $date->locale('fr')->format('D') }}
                        </span>
                        <span class="text-lg font-bold">{{ $date->format('d') }}</span>
                        <span class="text-xs {{ $index === 0 ? 'text-indigo-200' : 'text-gray-500' }}">
                            {{ $date->locale('fr')->format('M') }}
                        </span>
                    </button>
                @endforeach
            </div>
        </div>
        
        <!-- Showtimes by movie -->
        <div id="showtimes-container">
            @foreach($movieShowtimes as $movieId => $data)
                <div class="showtime-item bg-white rounded-lg shadow-md overflow-hidden mb-6" data-movie-id="{{ $movieId }}">
                    <div class="md:flex">
                        <!-- Movie poster -->
                        <div class="md:w-1/4 bg-gray-200 md:max-w-xs">
                            @if($data['movie']->image)
                                <img src="{{ $data['movie']->image }}" alt="{{ $data['movie']->title }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full min-h-48 flex items-center justify-center bg-gray-200">
                                    <i class="fas fa-film text-gray-400 text-5xl"></i>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Movie info and showtimes -->
                        <div class="md:w-3/4 p-6">
                            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4">
                                <h2 class="text-2xl font-bold text-gray-800 mb-2 md:mb-0">
                                    <a href="{{ route('movies.show', $data['movie']->id) }}" class="hover:text-indigo-600">
                                        {{ $data['movie']->title }}
                                    </a>
                                </h2>
                                
                                <div class="flex items-center">
                                    @if($data['movie']->min_age > 0)
                                        <span class="bg-red-100 text-red-800 text-sm px-3 py-1 rounded-full mr-2">
                                            {{ $data['movie']->min_age }}+
                                        </span>
                                    @endif
                                    
                                    <span class="bg-indigo-100 text-indigo-800 text-sm px-3 py-1 rounded-full">
                                        {{ $data['movie']->duration }} min
                                    </span>
                                </div>
                            </div>
                            
                            @if($data['movie']->genre)
                                <div class="mb-4">
                                    <span class="bg-blue-100 text-blue-800 text-sm px-3 py-1 rounded-full">
                                        {{ $data['movie']->genre }}
                                    </span>
                                </div>
                            @endif
                            
                            <!-- Showtimes by date -->
                            <div class="mt-6">
                                <h3 class="text-lg font-semibold text-gray-800 mb-3">Séances disponibles</h3>
                                
                                <div class="space-y-4">
                                    @foreach($data['showtime_dates'] as $date => $showtimesByDate)
                                        <div class="showtime-date" data-date="{{ $date }}">
                                            <h4 class="font-medium text-gray-700 mb-2">
                                                {{ \Carbon\Carbon::parse($date)->locale('fr')->isoFormat('dddd D MMMM') }}
                                            </h4>
                                            
                                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2">
                                                @foreach($showtimesByDate as $showtime)
                                                    <a href="{{ route('reservations.create', $showtime->id) }}" 
                                                        class="showtime-button flex items-center justify-between p-3 border rounded-md hover:bg-gray-50 transition-colors
                                                            {{ $showtime->type == 'VIP' ? 'border-yellow-400 bg-yellow-50 hover:bg-yellow-100' : 'border-indigo-300 bg-indigo-50 hover:bg-indigo-100' }}"
                                                        data-type="{{ $showtime->type }}"
                                                        data-language="{{ $showtime->language }}">
                                                        <span class="text-gray-800 font-medium">
                                                            {{ \Carbon\Carbon::parse($showtime->start_time)->format('H:i') }}
                                                        </span>
                                                        <div class="flex flex-col items-end">
                                                            <span class="text-xs {{ $showtime->type == 'VIP' ? 'text-yellow-800' : 'text-indigo-800' }}">
                                                                {{ $showtime->type }}
                                                            </span>
                                                            <span class="text-xs text-gray-600">
                                                                {{ $showtime->language }}
                                                            </span>
                                                        </div>
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Empty state -->
        <div id="empty-state" class="bg-white rounded-lg shadow-md p-8 text-center hidden">
            <div class="w-16 h-16 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4">
                <i class="fas fa-calendar-times text-gray-400 text-xl"></i>
            </div>
            <h2 class="text-xl font-bold text-gray-800 mb-2">Aucune séance trouvée</h2>
            <p class="text-gray-600 mb-6">Aucune séance ne correspond à vos critères de recherche.</p>
            <button id="reset-filters" class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-6 rounded-md font-medium transition duration-300">
                Réinitialiser les filtres
            </button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const dateFilter = document.getElementById('date-filter');
    const typeFilter = document.getElementById('type-filter');
    const languageFilter = document.getElementById('language-filter');
    const movieSearch = document.getElementById('movie-search');
    const dateButtons = document.querySelectorAll('.date-button');
    const showtimeItems = document.querySelectorAll('.showtime-item');
    const showtimeDates = document.querySelectorAll('.showtime-date');
    const showtimeButtons = document.querySelectorAll('.showtime-button');
    const emptyState = document.getElementById('empty-state');
    const resetFiltersBtn = document.getElementById('reset-filters');
    
    // Initialize current filters
    let currentFilters = {
        date: 'today',
        type: 'all',
        language: 'all',
        search: '',
        specificDate: getTodayDate()
    };
    
    // Get today's date in YYYY-MM-DD format
    function getTodayDate() {
        const today = new Date();
        return today.toISOString().split('T')[0];
    }
    
    // Filter showtimes based on current filters
    function filterShowtimes() {
        let foundShowtimes = false;
        
        // Process date filter
        if (currentFilters.date === 'today') {
            currentFilters.specificDate = getTodayDate();
        } else if (currentFilters.date === 'tomorrow') {
            const tomorrow = new Date();
            tomorrow.setDate(tomorrow.getDate() + 1);
            currentFilters.specificDate = tomorrow.toISOString().split('T')[0];
        } else if (currentFilters.date === 'week') {
            // Week filter will show all dates, handled below
        }
        
        // Iterate through each movie's showtimes
        showtimeItems.forEach(item => {
            const movieTitle = item.querySelector('h2').textContent.trim().toLowerCase();
            let movieHasShowtimes = false;
            
            // Check if movie title matches search
            const matchesSearch = currentFilters.search === '' || 
                                  movieTitle.includes(currentFilters.search.toLowerCase());
            
            if (!matchesSearch) {
                item.classList.add('hidden');
                return;
            }
            
            // Filter showtimes dates
            const dateElements = item.querySelectorAll('.showtime-date');
            dateElements.forEach(dateEl => {
                const dateValue = dateEl.dataset.date;
                let dateMatches = false;
                
                if (currentFilters.date === 'all') {
                    dateMatches = true;
                } else if (currentFilters.date === 'today' || currentFilters.date === 'tomorrow') {
                    dateMatches = dateValue === currentFilters.specificDate;
                } else if (currentFilters.date === 'week') {
                    // Check if date is within the next 7 days
                    const today = new Date();
                    const showDate = new Date(dateValue);
                    const weekFromNow = new Date();
                    weekFromNow.setDate(today.getDate() + 7);
                    
                    dateMatches = showDate >= today && showDate <= weekFromNow;
                } else if (currentFilters.date === 'specific') {
                    dateMatches = dateValue === currentFilters.specificDate;
                }
                
                if (!dateMatches) {
                    dateEl.classList.add('hidden');
                    return;
                } else {
                    dateEl.classList.remove('hidden');
                }
                
                // Filter showtimes by type and language
                const showtimeButtons = dateEl.querySelectorAll('.showtime-button');
                let dateHasShowtimes = false;
                
                showtimeButtons.forEach(button => {
                    const type = button.dataset.type;
                    const language = button.dataset.language;
                    
                    const typeMatches = currentFilters.type === 'all' || type === currentFilters.type;
                    const languageMatches = currentFilters.language === 'all' || language === currentFilters.language;
                    
                    if (typeMatches && languageMatches) {
                        button.classList.remove('hidden');
                        dateHasShowtimes = true;
                        movieHasShowtimes = true;
                        foundShowtimes = true;
                    } else {
                        button.classList.add('hidden');
                    }
                });
                
                // Hide date if it has no showtimes after filtering
                if (!dateHasShowtimes) {
                    dateEl.classList.add('hidden');
                }
            });
            
            // Hide movie if it has no showtimes after filtering
            if (!movieHasShowtimes) {
                item.classList.add('hidden');
            } else {
                item.classList.remove('hidden');
            }
        });
        
        // Show empty state if no showtimes found
        if (!foundShowtimes) {
            emptyState.classList.remove('hidden');
        } else {
            emptyState.classList.add('hidden');
        }
    }
    
    // Initialize filters
    filterShowtimes();
    
    // Handle filter changes
    dateFilter.addEventListener('change', function() {
        currentFilters.date = this.value;
        
        // Reset date buttons if not "specific" date
        if (this.value !== 'specific') {
            dateButtons.forEach(button => {
                button.classList.remove('bg-indigo-600', 'text-white');
                button.classList.add('bg-white', 'text-gray-800', 'hover:bg-gray-50');
                button.querySelectorAll('span').forEach(span => {
                    span.classList.remove('text-indigo-200');
                    span.classList.add('text-gray-500');
                });
            });
        }
        
        filterShowtimes();
    });
    
    typeFilter.addEventListener('change', function() {
        currentFilters.type = this.value;
        filterShowtimes();
    });
    
    languageFilter.addEventListener('change', function() {
        currentFilters.language = this.value;
        filterShowtimes();
    });
    
    movieSearch.addEventListener('input', function() {
        currentFilters.search = this.value;
        filterShowtimes();
    });
    
    // Handle date button clicks
    dateButtons.forEach(button => {
        button.addEventListener('click', function() {
            const date = this.dataset.date;
            
            // Update UI
            dateButtons.forEach(btn => {
                btn.classList.remove('bg-indigo-600', 'text-white');
                btn.classList.add('bg-white', 'text-gray-800', 'hover:bg-gray-50');
                btn.querySelectorAll('span').forEach(span => {
                    span.classList.remove('text-indigo-200');
                    span.classList.add('text-gray-500');
                });
            });
            
            this.classList.remove('bg-white', 'text-gray-800', 'hover:bg-gray-50');
            this.classList.add('bg-indigo-600', 'text-white');
            this.querySelectorAll('span').forEach(span => {
                span.classList.remove('text-gray-500');
                span.classList.add('text-indigo-200');
            });
            
            // Update filters
            dateFilter.value = 'specific';
            currentFilters.date = 'specific';
            currentFilters.specificDate = date;
            
            filterShowtimes();
        });
    });
    
    // Handle reset filters button
    resetFiltersBtn.addEventListener('click', function() {
        dateFilter.value = 'today';
        typeFilter.value = 'all';
        languageFilter.value = 'all';
        movieSearch.value = '';
        
        currentFilters = {
            date: 'today',
            type: 'all',
            language: 'all',
            search: '',
            specificDate: getTodayDate()
        };
        
        // Reset date buttons
        dateButtons.forEach((button, index) => {
            if (index === 0) {
                button.classList.remove('bg-white', 'text-gray-800', 'hover:bg-gray-50');
                button.classList.add('bg-indigo-600', 'text-white');
                button.querySelectorAll('span').forEach(span => {
                    span.classList.remove('text-gray-500');
                    span.classList.add('text-indigo-200');
                });
            } else {
                button.classList.remove('bg-indigo-600', 'text-white');
                button.classList.add('bg-white', 'text-gray-800', 'hover:bg-gray-50');
                button.querySelectorAll('span').forEach(span => {
                    span.classList.remove('text-indigo-200');
                    span.classList.add('text-gray-500');
                });
            }
        });
        
        filterShowtimes();
    });
});
</script>

<!-- Custom scrollbar styling for date navigation -->
<style>
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>
@endpush