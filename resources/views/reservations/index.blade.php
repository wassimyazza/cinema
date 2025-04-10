@extends('layouts.app')

@section('title', 'Mes Réservations - CinéHall')

@section('content')
<div class="bg-gray-100 py-8">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Mes Réservations</h1>
        
        <!-- Tabs -->
        <div class="flex border-b border-gray-200 mb-6">
            <button class="tab-btn active py-3 px-6 font-medium text-gray-800 border-b-2 border-indigo-600 focus:outline-none" data-tab="upcoming">
                À venir
            </button>
            <button class="tab-btn py-3 px-6 font-medium text-gray-500 hover:text-gray-800 border-b-2 border-transparent hover:border-gray-300 focus:outline-none" data-tab="past">
                Passées
            </button>
        </div>
        
        <!-- Upcoming reservations tab -->
        <div id="upcoming" class="tab-content">
            @if(count($upcomingReservations) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($upcomingReservations as $reservation)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            <div class="p-6">
                                <div class="flex justify-between items-start">
                                    <h2 class="text-xl font-bold text-gray-800">{{ $reservation->showtime->movie->title }}</h2>
                                    
                                    <span class="px-3 py-1 rounded-full text-xs font-medium 
                                        @if($reservation->status == 'paid')
                                            bg-green-100 text-green-800
                                        @elseif($reservation->status == 'pending')
                                            bg-yellow-100 text-yellow-800
                                        @else
                                            bg-red-100 text-red-800
                                        @endif
                                    ">
                                        @if($reservation->status == 'paid')
                                            Confirmée
                                        @elseif($reservation->status == 'pending')
                                            En attente de paiement
                                        @else
                                            Expirée
                                        @endif
                                    </span>
                                </div>
                                
                                <div class="mt-4 space-y-2 text-gray-600">
                                    <div class="flex items-start">
                                        <i class="fas fa-calendar-alt mt-1 mr-3 text-indigo-600 w-5 text-center"></i>
                                        <span>{{ \Carbon\Carbon::parse($reservation->showtime->start_time)->format('d/m/Y H:i') }}</span>
                                    </div>
                                    
                                    <div class="flex items-start">
                                        <i class="fas fa-map-marker-alt mt-1 mr-3 text-indigo-600 w-5 text-center"></i>
                                        <span>{{ $reservation->showtime->theater->name }} ({{ $reservation->showtime->type }})</span>
                                    </div>
                                    
                                    <div class="flex items-start">
                                        <i class="fas fa-ticket-alt mt-1 mr-3 text-indigo-600 w-5 text-center"></i>
                                        <span>{{ count($reservation->seats) }} {{ count($reservation->seats) > 1 ? 'places' : 'place' }}:
                                            @foreach($reservation->seats as $index => $seat)
                                                Rangée {{ $seat->row }}, Siège {{ $seat->number }}{{ $index < count($reservation->seats) - 1 ? '; ' : '' }}
                                            @endforeach
                                        </span>
                                    </div>
                                    
                                    <div class="flex items-start">
                                        <i class="fas fa-money-bill-wave mt-1 mr-3 text-indigo-600 w-5 text-center"></i>
                                        <span>Total: {{ number_format($reservation->total_price, 2, ',', ' ') }} €</span>
                                    </div>
                                    
                                    @if($reservation->status == 'pending')
                                        <div class="flex items-start">
                                            <i class="fas fa-clock mt-1 mr-3 text-red-600 w-5 text-center"></i>
                                            <span class="text-red-600">Expire le {{ \Carbon\Carbon::parse($reservation->expires_at)->format('d/m/Y H:i') }}</span>
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="mt-6 flex space-x-3">
                                    @if($reservation->status == 'paid')
                                        <a href="{{ route('tickets.show', $reservation->ticket->id) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-md text-sm font-medium transition duration-300">
                                            Voir le billet
                                        </a>
                                    @elseif($reservation->status == 'pending')
                                        <a href="{{ route('checkout', $reservation->id) }}" class="bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-md text-sm font-medium transition duration-300">
                                            Finaliser le paiement
                                        </a>
                                        
                                        <form method="POST" action="{{ route('reservations.destroy', $reservation->id) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-md text-sm font-medium transition duration-300" onclick="return confirm('Êtes-vous sûr de vouloir annuler cette réservation ?')">
                                                Annuler
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-lg shadow-md p-8 text-center">
                    <div class="w-16 h-16 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-ticket-alt text-gray-400 text-xl"></i>
                    </div>
                    <h2 class="text-xl font-bold text-gray-800 mb-2">Aucune réservation à venir</h2>
                    <p class="text-gray-600 mb-6">Vous n'avez pas de réservations prévues pour le moment.</p>
                    <a href="{{ route('movies.index') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-6 rounded-md font-medium transition duration-300">
                        Voir les films
                    </a>
                </div>
            @endif
        </div>
        
        <!-- Past reservations tab -->
        <div id="past" class="tab-content hidden">
            @if(count($pastReservations) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($pastReservations as $reservation)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            <div class="p-6">
                                <div class="flex justify-between items-start">
                                    <h2 class="text-xl font-bold text-gray-800">{{ $reservation->showtime->movie->title }}</h2>
                                    
                                    <span class="px-3 py-1 rounded-full text-xs font-medium 
                                        @if($reservation->status == 'paid')
                                            bg-green-100 text-green-800
                                        @else
                                            bg-gray-100 text-gray-800
                                        @endif
                                    ">
                                        @if($reservation->status == 'paid')
                                            Complétée
                                        @else
                                            Annulée/Expirée
                                        @endif
                                    </span>
                                </div>
                                
                                <div class="mt-4 space-y-2 text-gray-600">
                                    <div class="flex items-start">
                                        <i class="fas fa-calendar-alt mt-1 mr-3 text-indigo-600 w-5 text-center"></i>
                                        <span>{{ \Carbon\Carbon::parse($reservation->showtime->start_time)->format('d/m/Y H:i') }}</span>
                                    </div>
                                    
                                    <div class="flex items-start">
                                        <i class="fas fa-map-marker-alt mt-1 mr-3 text-indigo-600 w-5 text-center"></i>
                                        <span>{{ $reservation->showtime->theater->name }} ({{ $reservation->showtime->type }})</span>
                                    </div>
                                    
                                    <div class="flex items-start">
                                        <i class="fas fa-ticket-alt mt-1 mr-3 text-indigo-600 w-5 text-center"></i>
                                        <span>{{ count($reservation->seats) }} {{ count($reservation->seats) > 1 ? 'places' : 'place' }}</span>
                                    </div>
                                    
                                    <div class="flex items-start">
                                        <i class="fas fa-money-bill-wave mt-1 mr-3 text-indigo-600 w-5 text-center"></i>
                                        <span>Total: {{ number_format($reservation->total_price, 2, ',', ' ') }} €</span>
                                    </div>
                                </div>
                                
                                @if($reservation->status == 'paid' && $reservation->ticket)
                                    <div class="mt-6">
                                        <a href="{{ route('tickets.show', $reservation->ticket->id) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-md text-sm font-medium transition duration-300">
                                            Voir le billet
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-lg shadow-md p-8 text-center">
                    <div class="w-16 h-16 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-history text-gray-400 text-xl"></i>
                    </div>
                    <h2 class="text-xl font-bold text-gray-800 mb-2">Aucun historique de réservation</h2>
                    <p class="text-gray-600 mb-6">Vous n'avez pas encore de réservations passées.</p>
                    <a href="{{ route('movies.index') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-6 rounded-md font-medium transition duration-300">
                        Voir les films
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab switching functionality
    const tabButtons = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');
    
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all buttons
            tabButtons.forEach(btn => {
                btn.classList.remove('active');
                btn.classList.remove('text-gray-800');
                btn.classList.remove('border-indigo-600');
                btn.classList.add('text-gray-500');
                btn.classList.add('border-transparent');
            });
            
            // Add active class to clicked button
            this.classList.add('active');
            this.classList.remove('text-gray-500');
            this.classList.remove('border-transparent');
            this.classList.add('text-gray-800');
            this.classList.add('border-indigo-600');
            
            // Hide all tab contents
            tabContents.forEach(content => {
                content.classList.add('hidden');
            });
            
            // Show corresponding tab content
            const tabId = this.getAttribute('data-tab');
            document.getElementById(tabId).classList.remove('hidden');
        });
    });
    
    // Check for URL parameters to switch tabs
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('tab') === 'past') {
        document.querySelector('[data-tab="past"]').click();
    }
    
    // Show expiration warning if needed
    if (urlParams.get('expired') === 'true') {
        const warningElement = document.createElement('div');
        warningElement.className = 'bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6';
        warningElement.innerHTML = `
            <strong class="font-bold">Réservation expirée!</strong>
            <span class="block sm:inline">Votre réservation a expiré car le temps alloué pour le paiement s'est écoulé.</span>
            <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3 alert-close">
                <i class="fas fa-times"></i>
            </button>
        `;
        
        const container = document.querySelector('.container');
        container.insertBefore(warningElement, container.firstChild.nextSibling);
        
        // Add event listener to close button
        warningElement.querySelector('.alert-close').addEventListener('click', function() {
            warningElement.remove();
        });
    }
});
</script>
@endpush