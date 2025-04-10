@extends('layouts.app')

@section('title', 'Votre billet - CinéHall')

@section('content')
<div class="bg-gray-100 py-8">
    <div class="container mx-auto px-4">
        <div class="max-w-2xl mx-auto">
            <!-- Ticket header -->
            <div class="bg-white rounded-t-lg shadow-md p-6 border-b border-dashed border-gray-300">
                <div class="flex justify-between items-center mb-4">
                    <h1 class="text-2xl font-bold text-gray-800">Votre billet</h1>
                    <div class="flex space-x-2">
                        <a href="{{ route('tickets.download', $ticket->id) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded text-sm inline-flex items-center transition duration-300">
                            <i class="fas fa-download mr-2"></i> Télécharger
                        </a>
                        <button id="print-ticket" class="bg-gray-200 hover:bg-gray-300 text-gray-800 py-2 px-4 rounded text-sm inline-flex items-center transition duration-300">
                            <i class="fas fa-print mr-2"></i> Imprimer
                        </button>
                    </div>
                </div>
                
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center text-gray-600 mb-2">
                    <div>N° de réservation: <span class="font-medium">{{ $ticket->reservation->id }}</span></div>
                    <div>N° de billet: <span class="font-medium">{{ $ticket->ticket_number }}</span></div>
                </div>
                
                <div class="text-gray-600 text-sm">
                    <div>Émis le: {{ \Carbon\Carbon::parse($ticket->created_at)->format('d/m/Y H:i') }}</div>
                </div>
            </div>
            
            <!-- Ticket content -->
            <div class="bg-white shadow-md p-6 border-b border-dashed border-gray-300">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- Movie info -->
                    <div>
                        <h2 class="text-lg font-bold text-gray-800 mb-2">Détails du film</h2>
                        <div class="flex">
                            <div class="w-24 h-36 bg-gray-200 rounded overflow-hidden flex-shrink-0">
                                @if($ticket->reservation->showtime->movie->image)
                                    <img src="{{ $ticket->reservation->showtime->movie->image }}" alt="{{ $ticket->reservation->showtime->movie->title }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <i class="fas fa-film text-gray-400 text-3xl"></i>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="ml-4">
                                <h3 class="font-bold text-gray-800">{{ $ticket->reservation->showtime->movie->title }}</h3>
                                <div class="text-sm text-gray-600 mt-1">
                                    <div class="mb-1">Durée: {{ $ticket->reservation->showtime->movie->duration }} min</div>
                                    
                                    @if($ticket->reservation->showtime->movie->min_age > 0)
                                        <div class="mb-1">Âge minimum: {{ $ticket->reservation->showtime->movie->min_age }}+</div>
                                    @endif
                                    
                                    @if($ticket->reservation->showtime->movie->genre)
                                        <div>Genre: {{ $ticket->reservation->showtime->movie->genre }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Show info -->
                    <div>
                        <h2 class="text-lg font-bold text-gray-800 mb-2">Détails de la séance</h2>
                        <div class="space-y-2 text-gray-600">
                            <div class="flex items-start">
                                <i class="fas fa-calendar-alt mt-1 mr-3 text-indigo-600 w-5 text-center"></i>
                                <div>
                                    <div class="font-medium">Date</div>
                                    <div>{{ \Carbon\Carbon::parse($ticket->reservation->showtime->start_time)->format('d/m/Y') }}</div>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <i class="fas fa-clock mt-1 mr-3 text-indigo-600 w-5 text-center"></i>
                                <div>
                                    <div class="font-medium">Heure</div>
                                    <div>{{ \Carbon\Carbon::parse($ticket->reservation->showtime->start_time)->format('H:i') }}</div>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <i class="fas fa-map-marker-alt mt-1 mr-3 text-indigo-600 w-5 text-center"></i>
                                <div>
                                    <div class="font-medium">Salle</div>
                                    <div>{{ $ticket->reservation->showtime->theater->name }} ({{ $ticket->reservation->showtime->type }})</div>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <i class="fas fa-language mt-1 mr-3 text-indigo-600 w-5 text-center"></i>
                                <div>
                                    <div class="font-medium">Langue</div>
                                    <div>{{ $ticket->reservation->showtime->language }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Seat info -->
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">Places réservées</h2>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        @foreach($ticket->reservation->seats as $seat)
                            <div class="bg-gray-50 rounded-lg p-3 border border-gray-200">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <div class="font-medium text-gray-800">Rangée {{ $seat->row }}, Siège {{ $seat->number }}</div>
                                        <div class="text-sm text-gray-600">{{ $seat->type == 'Couple' ? 'Siège couple' : 'Siège standard' }}</div>
                                    </div>
                                    <div class="text-2xl text-indigo-600">
                                        <i class="fas {{ $seat->type == 'Couple' ? 'fa-couch' : 'fa-chair' }}"></i>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            
            <!-- QR Code -->
            <div class="bg-white rounded-b-lg shadow-md p-6 text-center">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Code d'accès</h2>
                <p class="text-gray-600 mb-4">Présentez ce code à l'entrée du cinéma</p>
                
                <div class="flex justify-center">
                    <div class="bg-white p-3 rounded-lg border border-gray-300 inline-block">
                        <div id="qrcode" class="w-48 h-48 flex items-center justify-center">
                            <div class="animate-spin w-8 h-8 border-4 border-indigo-500 border-t-transparent rounded-full"></div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-4 font-medium text-gray-800">{{ $ticket->ticket_number }}</div>
            </div>
            
            <!-- Actions -->
            <div class="mt-6 text-center">
                <a href="{{ route('reservations.index') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                    Retour à mes réservations
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/qrious@4.0.2/dist/qrious.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Generate QR Code
    const qrContainer = document.getElementById('qrcode');
    
    // Clear loading spinner
    qrContainer.innerHTML = '';
    
    new QRious({
        element: qrContainer.appendChild(document.createElement('canvas')),
        value: '{{ $ticket->ticket_number }}',
        size: 200,
        backgroundAlpha: 1,
        foreground: '#4f46e5',
        level: 'H' // High error correction
    });
    
    // Handle print button
    document.getElementById('print-ticket').addEventListener('click', function() {
        window.print();
    });
});
</script>
@endpush

@push('styles')
<style>
@media print {
    body * {
        visibility: hidden;
    }
    
    .container {
        max-width: 100% !important;
    }
    
    .max-w-2xl {
        max-width: 100% !important;
    }
    
    .shadow-md {
        box-shadow: none !important;
    }
    
    header, footer, #print-ticket, .bg-gray-100 {
        background-color: white !important;
    }
    
    .max-w-2xl, .max-w-2xl * {
        visibility: visible;
    }
    
    .max-w-2xl {
        position: absolute;
        left: 0;
        top: 0;
    }
    
    a[href="{{ route('tickets.download', $ticket->id) }}"], 
    #print-ticket, 
    a[href="{{ route('reservations.index') }}"] {
        display: none !important;
    }
}
</style>
@endpush