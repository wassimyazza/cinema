@extends('layouts.app')

@section('title', 'Réservation de places - CinéHall')

@section('content')
<div class="bg-gray-100 min-h-screen py-8">
    <div class="container mx-auto px-4">
        <!-- Reservation progress bar -->
        <div class="mb-8">
            <div class="flex items-center justify-center">
                <div class="flex items-center text-indigo-600">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full bg-indigo-600 text-white">
                        1
                    </div>
                    <span class="ml-2 font-medium">Sélection des sièges</span>
                </div>
                <div class="flex-1 h-1 mx-4 bg-indigo-200">
                    <div class="h-1 bg-indigo-600" style="width: 0%"></div>
                </div>
                <div class="flex items-center text-gray-400">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full bg-gray-300">
                        2
                    </div>
                    <span class="ml-2 font-medium">Paiement</span>
                </div>
                <div class="flex-1 h-1 mx-4 bg-gray-300"></div>
                <div class="flex items-center text-gray-400">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full bg-gray-300">
                        3
                    </div>
                    <span class="ml-2 font-medium">Confirmation</span>
                </div>
            </div>
        </div>
        
        <!-- Showtime info -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">{{ $showtime->movie->title }}</h1>
                    <div class="flex items-center mt-2 text-gray-600">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        <span>{{ \Carbon\Carbon::parse($showtime->start_time)->format('d/m/Y') }}</span>
                        <span class="mx-2">|</span>
                        <i class="fas fa-clock mr-2"></i>
                        <span>{{ \Carbon\Carbon::parse($showtime->start_time)->format('H:i') }}</span>
                        <span class="mx-2">|</span>
                        <i class="fas fa-map-marker-alt mr-2"></i>
                        <span>{{ $showtime->theater->name }}</span>
                    </div>
                    <div class="mt-2">
                        <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium {{ $showtime->type == 'VIP' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800' }}">
                            {{ $showtime->type }}
                        </span>
                        <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-green-100 text-green-800 ml-2">
                            {{ $showtime->language }}
                        </span>
                    </div>
                </div>
                <div class="mt-4 md:mt-0">
                    <div id="reservation-timer" class="text-right text-gray-600">
                        <p class="text-sm">Votre réservation expirera après:</p>
                        <div class="text-xl font-bold text-red-600">15:00</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Seat map section -->
            <div class="lg:w-2/3">
                <div class="bg-white rounded-lg shadow-md p-6 mb-4">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Sélectionnez vos places</h2>
                    
                    <!-- Screen -->
                    <div class="relative mb-10 text-center">
                        <div class="w-3/4 h-4 bg-indigo-200 mx-auto rounded"></div>
                        <div class="w-11/12 h-1 bg-indigo-100 mx-auto mt-1 mb-4 rounded"></div>
                        <span class="text-xs text-gray-500">ÉCRAN</span>
                    </div>
                    
                    <!-- Seat map -->
                    <div id="seat-map" class="grid grid-cols-10 gap-2 mb-6">
                        <!-- Seats will be loaded dynamically -->
                        <div class="col-span-10 text-center py-10">
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
            </div>
            
            <!-- Order summary section -->
            <div class="lg:w-1/3">
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Résumé de la commande</h2>
                    
                    <div class="border-t border-b border-gray-200 py-4 mb-4">
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600">Film:</span>
                            <span class="font-medium">{{ $showtime->movie->title }}</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600">Séance:</span>
                            <span class="font-medium">{{ \Carbon\Carbon::parse($showtime->start_time)->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600">Salle:</span>
                            <span class="font-medium">{{ $showtime->theater->name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Type:</span>
                            <span class="font-medium">{{ $showtime->type }}</span>
                        </div>
                    </div>
                    
                    <div id="selected-seats-container" class="mb-4">
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600">Places sélectionnées:</span>
                            <span id="seats-count" class="font-medium">0</span>
                        </div>
                        <div id="selected-seats-list" class="text-gray-700 pl-4 space-y-1"></div>
                    </div>
                    
                    <div class="border-t border-gray-200 pt-4 mb-6">
                        <div class="flex justify-between text-lg font-bold">
                            <span>Total:</span>
                            <span id="total-price">0,00 €</span>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">TVA incluse</p>
                    </div>
                    
                    <form id="reservation-form" method="POST" action="{{ route('reservations.store') }}">
                        @csrf
                        <input type="hidden" name="showtime_id" value="{{ $showtime->id }}">
                        <input type="hidden" name="seat_ids" id="seat-ids-input">
                        <input type="hidden" name="total_price" id="total-price-input">
                        
                        <button type="submit" id="continue-btn" class="w-full bg-indigo-600 text-white py-3 px-4 rounded-lg font-bold hover:bg-indigo-700 transition duration-300 disabled:bg-gray-400 disabled:cursor-not-allowed" disabled>
                            Continuer vers le paiement
                        </button>
                    </form>
                    
                    <p class="text-sm text-gray-500 mt-4 text-center">
                        <i class="fas fa-lock mr-1"></i>
                        Paiement sécurisé. Vous pouvez annuler votre réservation jusqu'à 24h avant la séance.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const seatMap = document.getElementById('seat-map');
    const selectedSeatsList = document.getElementById('selected-seats-list');
    const seatsCount = document.getElementById('seats-count');
    const totalPrice = document.getElementById('total-price');
    const seatIdsInput = document.getElementById('seat-ids-input');
    const totalPriceInput = document.getElementById('total-price-input');
    const continueBtn = document.getElementById('continue-btn');
    
    // Pricing based on seat type and showtime type
    const prices = {
        'Regular': {
            'Normal': 10,
            'VIP': 15
        },
        'Couple': {
            'Normal': 18,  // Price per couple seat (for 2 people)
            'VIP': 25      // Price per couple seat (for 2 people)
        }
    };
    
    const showtimeType = "{{ $showtime->type }}";
    const selectedSeats = new Set();
    let theaterRows = [];
    let seatsByPosition = {};
    
    // Timer for reservation expiration (15 minutes)
    let timeLeft = 15 * 60; // 15 minutes in seconds
    const timerElement = document.getElementById('reservation-timer').querySelector('div');
    
    function startTimer() {
        const timer = setInterval(function() {
            timeLeft--;
            
            if (timeLeft <= 0) {
                clearInterval(timer);
                // Redirect to showtime page with expiration message
                window.location.href = "{{ route('showtimes.show', $showtime->id) }}?expired=true";
            }
            
            // Format time as mm:ss
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            timerElement.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            
            // Change color when time is running out
            if (timeLeft < 60) {
                timerElement.classList.add('animate-pulse');
            }
        }, 1000);
    }
    
    // Load available seats
    async function loadSeats() {
        try {
            // Fetch available seats for this showtime
            const response = await fetch(`/api/seats/available/${{{ $showtime->id }}}`);
            const data = await response.json();
            
            if (!data || data.length === 0) {
                seatMap.innerHTML = `
                    <div class="col-span-10 text-center py-10">
                        <i class="fas fa-exclamation-circle text-red-500 text-4xl mb-4"></i>
                        <p class="text-lg font-medium text-gray-700">Aucun siège disponible</p>
                        <p class="text-gray-600 mt-2">Toutes les places pour cette séance sont réservées.</p>
                        <a href="{{ route('showtimes.by-movie', $showtime->movie->id) }}" class="inline-block mt-4 bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded transition duration-300">
                            Voir d'autres séances
                        </a>
                    </div>
                `;
                return;
            }
            
            // Extract all rows and organize seats
            theaterRows = [...new Set(data.map(seat => seat.row))].sort();
            
            // Group seats by position for easier rendering
            data.forEach(seat => {
                const key = `${seat.row}_${seat.number}`;
                seatsByPosition[key] = seat;
            });
            
            // Build seat map HTML
            renderSeatMap();
            
        } catch (error) {
            console.error('Error loading seats:', error);
            seatMap.innerHTML = `
                <div class="col-span-10 text-center py-10">
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
    
    function renderSeatMap() {
        seatMap.innerHTML = '';
        
        // Add row labels and seats
        theaterRows.forEach(row => {
            // Row label
            const rowLabel = document.createElement('div');
            rowLabel.className = 'flex items-center justify-center text-gray-600 font-medium';
            rowLabel.textContent = row;
            seatMap.appendChild(rowLabel);
            
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
                    
                    seatDiv.className = `seat flex items-center justify-center h-10 rounded text-sm font-medium cursor-pointer ${isCouple ? 'seat-couple' : 'seat-available'}`;
                    seatDiv.textContent = seatNum;
                    seatDiv.dataset.id = seat.id;
                    seatDiv.dataset.row = row;
                    seatDiv.dataset.number = seatNum;
                    seatDiv.dataset.type = seat.type;
                    seatDiv.dataset.price = prices[seat.type][showtimeType];
                    
                    // Handle seat click
                    seatDiv.addEventListener('click', function() {
                        toggleSeat(this);
                    });
                } else {
                    // Empty space or unavailable seat
                    seatDiv.className = 'invisible';
                }
                
                seatMap.appendChild(seatDiv);
            }
            
            // Add a line break after each row
            const spacer = document.createElement('div');
            spacer.className = 'col-span-10 h-2';
            seatMap.appendChild(spacer);
        });
        
        // Start the reservation timer
        startTimer();
    }
    
    function toggleSeat(seatElement) {
        const id = seatElement.dataset.id;
        const row = seatElement.dataset.row;
        const number = seatElement.dataset.number;
        const type = seatElement.dataset.type;
        
        if (seatElement.classList.contains('seat-selected')) {
            // Deselect seat
            seatElement.classList.remove('seat-selected');
            seatElement.classList.add(type === 'Couple' ? 'seat-couple' : 'seat-available');
            selectedSeats.delete(id);
        } else {
            // Select seat
            seatElement.classList.remove(type === 'Couple' ? 'seat-couple' : 'seat-available');
            seatElement.classList.add('seat-selected');
            selectedSeats.add(id);
        }
        
        updateOrderSummary();
    }
    
    function updateOrderSummary() {
        // Update selected seats count
        seatsCount.textContent = selectedSeats.size;
        
        // Clear and rebuild selected seats list
        selectedSeatsList.innerHTML = '';
        
        if (selectedSeats.size === 0) {
            continueBtn.disabled = true;
            totalPrice.textContent = '0,00 €';
            seatIdsInput.value = '';
            totalPriceInput.value = '';
            return;
        }
        
        // Calculate total price and build list
        let totalPriceValue = 0;
        const selectedSeatsArray = [];
        
        // Collect all selected seats
        document.querySelectorAll('.seat.seat-selected').forEach(seat => {
            const id = seat.dataset.id;
            const row = seat.dataset.row;
            const number = seat.dataset.number;
            const type = seat.dataset.type;
            const price = parseFloat(seat.dataset.price);
            
            totalPriceValue += price;
            selectedSeatsArray.push(id);
            
            // Add to visible list
            const seatItem = document.createElement('div');
            seatItem.className = 'flex justify-between';
            seatItem.innerHTML = `
                <span>Rangée ${row}, Siège ${number} ${type === 'Couple' ? '(Couple)' : ''}</span>
                <span>${price.toFixed(2)} €</span>
            `;
            selectedSeatsList.appendChild(seatItem);
        });
        
        // Update UI
        totalPrice.textContent = `${totalPriceValue.toFixed(2)} €`;
        continueBtn.disabled = false;
        
        // Update form inputs
        seatIdsInput.value = JSON.stringify(selectedSeatsArray);
        totalPriceInput.value = totalPriceValue.toFixed(2);
    }
    
    // Handle form submission
    document.getElementById('reservation-form').addEventListener('submit', function(event) {
        if (selectedSeats.size === 0) {
            event.preventDefault();
            alert('Veuillez sélectionner au moins un siège.');
        }
    });
    
    // Initialize
    loadSeats();
});
</script>
@endpush