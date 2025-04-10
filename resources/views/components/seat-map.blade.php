@props(['showtime', 'selectedSeats' => [], 'mode' => 'selection', 'readOnly' => false])

<div {{ $attributes->merge(['class' => 'seat-map']) }}>
    <!-- Screen -->
    <div class="relative mb-10 text-center">
        <div class="w-3/4 h-4 bg-indigo-200 mx-auto rounded"></div>
        <div class="w-11/12 h-1 bg-indigo-100 mx-auto mt-1 mb-4 rounded"></div>
        <span class="text-xs text-gray-500">ÉCRAN</span>
    </div>
    
    <!-- Seats -->
    <div id="seats-container" class="grid gap-2" 
        data-showtime-id="{{ $showtime->id }}" 
        data-mode="{{ $mode }}" 
        data-readonly="{{ $readOnly ? 'true' : 'false' }}">
        <!-- Seats will be loaded here -->
        <div class="col-span-full text-center py-10">
            <div class="animate-spin inline-block w-8 h-8 border-4 border-indigo-500 border-t-transparent rounded-full"></div>
            <p class="mt-2 text-gray-600">Chargement du plan de salle...</p>
        </div>
    </div>
    
    <!-- Seat legend -->
    <div class="flex flex-wrap justify-center gap-4 mt-8 text-sm">
        <div class="flex items-center">
            <div class="w-6 h-6 bg-gray-300 rounded mr-2"></div>
            <span>Disponible</span>
        </div>
        <div class="flex items-center">
            <div class="w-6 h-6 bg-blue-500 rounded mr-2"></div>
            <span>Sélectionné</span>
        </div>
        <div class="flex items-center">
            <div class="w-6 h-6 bg-gray-600 rounded mr-2"></div>
            <span>Occupé</span>
        </div>
        <div class="flex items-center">
            <div class="w-6 h-6 bg-pink-300 rounded mr-2"></div>
            <span>Siège couple</span>
        </div>
    </div>
</div>

@once
<style>
    /* Seat styling */
    .seat {
        transition: all 0.2s ease;
    }
    .seat-available {
        @apply bg-gray-300 hover:bg-blue-400 cursor-pointer;
    }
    .seat-selected {
        @apply bg-blue-500 text-white;
    }
    .seat-occupied {
        @apply bg-gray-600 text-white cursor-not-allowed;
    }
    .seat-couple {
        @apply bg-pink-300 hover:bg-pink-400;
    }
    .seat-couple.seat-selected {
        @apply bg-pink-500;
    }
</style>
@endonce

<script>
document.addEventListener('DOMContentLoaded', function() {
    const seatsContainer = document.getElementById('seats-container');
    const showtimeId = seatsContainer.dataset.showtimeId;
    const mode = seatsContainer.dataset.mode;
    const isReadOnly = seatsContainer.dataset.readonly === 'true';
    const selectedSeatsData = @json($selectedSeats);
    
    // Set of selected seat IDs
    const selectedSeatIds = new Set(selectedSeatsData.map(seat => seat.id));
    
    // Initialize
    loadSeats();
    
    // Load seats from API
    async function loadSeats() {
        try {
            // Fetch available seats for this showtime
            const response = await fetch(`/api/seats/available/${showtimeId}`);
            const data = await response.json();
            
            if (!data || data.length === 0) {
                seatsContainer.innerHTML = `
                    <div class="col-span-full text-center py-10">
                        <i class="fas fa-exclamation-circle text-red-500 text-4xl mb-4"></i>
                        <p class="text-lg font-medium text-gray-700">Aucun siège disponible</p>
                        <p class="text-gray-600 mt-2">Toutes les places pour cette séance sont réservées.</p>
                    </div>
                `;
                return;
            }
            
            // Extract all rows and organize seats
            const rows = [...new Set(data.map(seat => seat.row))].sort();
            
            // Group seats by position for easier rendering
            const seatsByPosition = {};
            data.forEach(seat => {
                const key = `${seat.row}_${seat.number}`;
                seatsByPosition[key] = seat;
            });
            
            // Build seat map HTML
            renderSeatMap(rows, seatsByPosition);
            
            // If in selection mode, add event listeners
            if (mode === 'selection' && !isReadOnly) {
                addSeatEventListeners();
                
                // Trigger seat selection update event
                const event = new CustomEvent('seat-selection-update', {
                    detail: {
                        selectedSeats: Array.from(selectedSeatIds).map(id => {
                            const seat = data.find(s => s.id.toString() === id.toString());
                            return seat;
                        })
                    }
                });
                document.dispatchEvent(event);
            }
            
        } catch (error) {
            console.error('Error loading seats:', error);
            seatsContainer.innerHTML = `
                <div class="col-span-full text-center py-10">
                    <i class="fas fa-exclamation-triangle text-red-500 text-4xl mb-4"></i>
                    <p class="text-lg font-medium text-gray-700">Erreur lors du chargement des sièges</p>
                    <p class="text-gray-600 mt-2">Veuillez réessayer ultérieurement.</p>
                    <button id="retry-btn" class="mt-4 bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded transition duration-300">
                        Réessayer
                    </button>
                </div>
            `;
            
            document.getElementById('retry-btn').addEventListener('click', loadSeats);
        }
    }
    
    function renderSeatMap(rows, seatsByPosition) {
        seatsContainer.innerHTML = '';
        
        // Calculate the number of columns based on the maximum seats in any row
        let maxSeatsInRow = 0;
        rows.forEach(row => {
            const seatsInThisRow = Object.keys(seatsByPosition)
                .filter(key => key.startsWith(`${row}_`))
                .length;
            maxSeatsInRow = Math.max(maxSeatsInRow, seatsInThisRow);
        });
        
        // Set the grid columns
        seatsContainer.style.gridTemplateColumns = `auto repeat(${maxSeatsInRow}, minmax(0, 1fr))`;
        
        // Add rows and seats
        rows.forEach(row => {
            // Row label
            const rowLabel = document.createElement('div');
            rowLabel.className = 'flex items-center justify-center font-medium text-gray-600';
            rowLabel.textContent = row;
            seatsContainer.appendChild(rowLabel);
            
            // Find max seat number in this row
            const maxSeatInRow = Math.max(...Object.keys(seatsByPosition)
                .filter(key => key.startsWith(`${row}_`))
                .map(key => parseInt(key.split('_')[1])));
            
            // Create seats for this row
            for (let seatNum = 1; seatNum <= maxSeatInRow; seatNum++) {
                const key = `${row}_${seatNum}`;
                const seat = seatsByPosition[key];
                
                const seatDiv = document.createElement('div');
                
                if (seat) {
                    const isCouple = seat.type === 'Couple';
                    const isOccupied = seat.is_occupied;
                    const isSelected = selectedSeatIds.has(seat.id.toString());
                    
                    let seatClass = '';
                    
                    if (isReadOnly) {
                        // For read only mode
                        if (isSelected) {
                            seatClass = isCouple ? 'seat seat-couple seat-selected' : 'seat seat-selected';
                        } else if (isOccupied) {
                            seatClass = 'seat seat-occupied';
                        } else {
                    // Select seat
                    this.classList.remove(this.dataset.type === 'Couple' ? 'seat-couple' : 'seat-available');
                    this.classList.add('seat-selected');
                    selectedSeatIds.add(id);
                }
                
                // Trigger seat selection update event
                const seatsData = Array.from(seatsContainer.querySelectorAll('.seat-selected')).map(seat => ({
                    id: seat.dataset.id,
                    row: seat.dataset.row,
                    number: seat.dataset.number,
                    type: seat.dataset.type,
                    price: parseFloat(seat.dataset.price)
                }));
                
                const event = new CustomEvent('seat-selection-update', {
                    detail: {
                        selectedSeats: seatsData
                    }
                });
                document.dispatchEvent(event);
            });
        });
    }
});
</script>
