@extends('layouts.admin')

@section('title', 'Gestion des séances - Administration CinéHall')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
        <div class="lg:flex lg:items-center lg:justify-between mb-6">
            <div class="flex-1 min-w-0">
                <h1 class="text-2xl font-semibold text-gray-900">Gestion des séances</h1>
                <p class="mt-1 text-sm text-gray-500">
                    Gérez toutes les séances de cinéma
                </p>
            </div>
            <div class="mt-5 flex lg:mt-0 lg:ml-4">
                <a href="{{ route('admin.showtimes.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <i class="fas fa-plus mr-2"></i>
                    Ajouter une séance
                </a>
            </div>
        </div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
        <!-- Filters -->
        <div class="bg-white shadow rounded-lg mb-6">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex flex-col md:flex-row md:items-end space-y-4 md:space-y-0 md:space-x-4">
                    <div>
                        <label for="movie-filter" class="block text-sm font-medium text-gray-700">Film</label>
                        <select id="movie-filter" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option value="">Tous les films</option>
                            @foreach($movies as $movie)
                                <option value="{{ $movie->id }}">{{ $movie->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label for="theater-filter" class="block text-sm font-medium text-gray-700">Salle</label>
                        <select id="theater-filter" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option value="">Toutes les salles</option>
                            @foreach($theaters as $theater)
                                <option value="{{ $theater->id }}">{{ $theater->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label for="date-filter" class="block text-sm font-medium text-gray-700">Date</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input type="date" id="date-filter" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-3 pr-10 py-2 sm:text-sm border-gray-300 rounded-md">
                        </div>
                    </div>
                    
                    <div>
                        <label for="type-filter" class="block text-sm font-medium text-gray-700">Type</label>
                        <select id="type-filter" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option value="">Tous les types</option>
                            <option value="Normal">Normal</option>
                            <option value="VIP">VIP</option>
                        </select>
                    </div>
                    
                    <button id="clear-filters" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <i class="fas fa-times mr-2"></i>
                        Effacer les filtres
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Showtimes Table -->
        <div class="bg-white shadow overflow-hidden rounded-lg">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Film
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Date & Heure
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
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Réservations
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($showtimes as $showtime)
                            <tr class="showtime-row" 
                                data-movie="{{ $showtime->movie_id }}" 
                                data-theater="{{ $showtime->theater_id }}" 
                                data-date="{{ \Carbon\Carbon::parse($showtime->start_time)->format('Y-m-d') }}" 
                                data-type="{{ $showtime->type }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-gray-100 rounded overflow-hidden">
                                            @if($showtime->movie->image)
                                                <img src="{{ $showtime->movie->image }}" alt="{{ $showtime->movie->title }}" class="h-10 w-10 object-cover">
                                            @else
                                                <div class="h-10 w-10 flex items-center justify-center">
                                                    <i class="fas fa-film text-gray-400"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $showtime->movie->title }}
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                {{ $showtime->movie->duration }} min | {{ $showtime->movie->genre ?: 'Non catégorisé' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ \Carbon\Carbon::parse($showtime->start_time)->format('d/m/Y') }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ \Carbon\Carbon::parse($showtime->start_time)->format('H:i') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $showtime->theater->name }}</div>
                                    <div class="text-xs text-gray-500">Capacité: {{ $showtime->theater->capacity }} places</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $showtime->type == 'VIP' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ $showtime->type }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $showtime->language }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $reservationCount = $showtime->reservations->where('status', 'paid')->count();
                                        $seatsSold = $showtime->reservations->where('status', 'paid')->sum(function($reservation) {
                                            return $reservation->seats->count();
                                        });
                                        $occupancyRate = $showtime->theater->capacity > 0 ? ($seatsSold / $showtime->theater->capacity) * 100 : 0;
                                    @endphp

                                    <div class="text-sm text-gray-900">{{ $reservationCount }} réservation(s)</div>
                                    <div class="text-xs text-gray-500">{{ $seatsSold }} places vendues ({{ number_format($occupancyRate, 1) }}%)</div>
                                    
                                    <div class="w-full bg-gray-200 rounded-full h-1.5 mt-1">
                                        <div class="bg-indigo-600 h-1.5 rounded-full" style="width: {{ min($occupancyRate, 100) }}%"></div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        <a href="{{ route('admin.showtimes.edit', $showtime->id) }}" class="text-indigo-600 hover:text-indigo-900" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('showtimes.show', $showtime->id) }}" class="text-blue-600 hover:text-blue-900" title="Voir" target="_blank">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button type="button" class="text-red-600 hover:text-red-900 delete-showtime" data-id="{{ $showtime->id }}" data-title="{{ $showtime->movie->title }}" data-time="{{ \Carbon\Carbon::parse($showtime->start_time)->format('d/m/Y H:i') }}" title="Supprimer">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        
                        <!-- Empty state when no showtimes match filters -->
                        <tr id="empty-row" class="hidden">
                            <td colspan="7" class="px-6 py-10 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-calendar-times text-gray-400 text-3xl mb-3"></i>
                                    <p class="text-gray-500 text-lg font-medium">Aucune séance trouvée</p>
                                    <p class="text-gray-400 mt-1">Essayez de modifier vos filtres ou d'ajouter une nouvelle séance</p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($showtimes->hasPages())
                <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                    {{ $showtimes->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div id="delete-modal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <i class="fas fa-exclamation-triangle text-red-600"></i>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Supprimer la séance
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                Êtes-vous sûr de vouloir supprimer la séance de <span id="movie-title-to-delete"></span> du <span id="showtime-to-delete"></span> ? Cette action est irréversible et supprimera également toutes les réservations associées à cette séance.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <form id="delete-form" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Supprimer
                    </button>
                </form>
                <button type="button" id="cancel-delete" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Annuler
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filter showtimes
    const movieFilter = document.getElementById('movie-filter');
    const theaterFilter = document.getElementById('theater-filter');
    const dateFilter = document.getElementById('date-filter');
    const typeFilter = document.getElementById('type-filter');
    const clearFiltersBtn = document.getElementById('clear-filters');
    const showtimeRows = document.querySelectorAll('.showtime-row');
    const emptyRow = document.getElementById('empty-row');
    
    function filterShowtimes() {
        const selectedMovie = movieFilter.value;
        const selectedTheater = theaterFilter.value;
        const selectedDate = dateFilter.value;
        const selectedType = typeFilter.value;
        let visibleCount = 0;
        
        showtimeRows.forEach(row => {
            const movieId = row.dataset.movie;
            const theaterId = row.dataset.theater;
            const date = row.dataset.date;
            const type = row.dataset.type;
            
            const matchesMovie = selectedMovie === '' || movieId === selectedMovie;
            const matchesTheater = selectedTheater === '' || theaterId === selectedTheater;
            const matchesDate = selectedDate === '' || date === selectedDate;
            const matchesType = selectedType === '' || type === selectedType;
            
            if (matchesMovie && matchesTheater && matchesDate && matchesType) {
                row.classList.remove('hidden');
                visibleCount++;
            } else {
                row.classList.add('hidden');
            }
        });
        
        // Show/hide empty state
        if (visibleCount === 0) {
            emptyRow.classList.remove('hidden');
        } else {
            emptyRow.classList.add('hidden');
        }
    }
    
    movieFilter.addEventListener('change', filterShowtimes);
    theaterFilter.addEventListener('change', filterShowtimes);
    dateFilter.addEventListener('change', filterShowtimes);
    typeFilter.addEventListener('change', filterShowtimes);
    
    clearFiltersBtn.addEventListener('click', function() {
        movieFilter.value = '';
        theaterFilter.value = '';
        dateFilter.value = '';
        typeFilter.value = '';
        filterShowtimes();
    });
    
    // Handle delete modal
    const deleteModal = document.getElementById('delete-modal');
    const deleteButtons = document.querySelectorAll('.delete-showtime');
    const cancelDeleteBtn = document.getElementById('cancel-delete');
    const movieTitleElement = document.getElementById('movie-title-to-delete');
    const showtimeElement = document.getElementById('showtime-to-delete');
    const deleteForm = document.getElementById('delete-form');
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const showtimeId = this.dataset.id;
            const movieTitle = this.dataset.title;
            const showtimeDateTime = this.dataset.time;
            
            // Update modal content
            movieTitleElement.textContent = movieTitle;
            showtimeElement.textContent = showtimeDateTime;
            deleteForm.action = `/admin/showtimes/${showtimeId}`;
            
            // Show modal
            deleteModal.classList.remove('hidden');
        });
    });
    
    cancelDeleteBtn.addEventListener('click', function() {
        deleteModal.classList.add('hidden');
    });
    
    // Close modal when clicking outside
    deleteModal.addEventListener('click', function(e) {
        if (e.target === deleteModal) {
            deleteModal.classList.add('hidden');
        }
    });
    
    // Close modal with escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !deleteModal.classList.contains('hidden')) {
            deleteModal.classList.add('hidden');
        }
    });
});
</script>
@endpush