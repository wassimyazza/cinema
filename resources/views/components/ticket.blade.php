@props(['ticket', 'printable' => false])

<div {{ $attributes->merge(['class' => 'bg-white rounded-lg shadow-md overflow-hidden ticket']) }}>
    <!-- Ticket header with logo and number -->
    <div class="bg-indigo-600 text-white px-6 py-4 flex justify-between items-center">
        <div class="flex items-center">
            <i class="fas fa-film text-2xl mr-2"></i>
            <span class="text-xl font-bold">CinéHall</span>
        </div>
        <div class="text-sm">
            <div>N° {{ $ticket->ticket_number }}</div>
            <div>{{ \Carbon\Carbon::parse($ticket->created_at)->format('d/m/Y') }}</div>
        </div>
    </div>
    
    <!-- Main ticket content -->
    <div class="p-6 border-b border-dashed border-gray-300">
        <!-- Movie title and showtime -->
        <div class="flex justify-between items-start mb-4">
            <h2 class="text-xl font-bold text-gray-800">{{ $ticket->reservation->showtime->movie->title }}</h2>
            <div class="text-right">
                <div class="text-indigo-600 font-bold">{{ \Carbon\Carbon::parse($ticket->reservation->showtime->start_time)->format('H:i') }}</div>
                <div class="text-gray-600">{{ \Carbon\Carbon::parse($ticket->reservation->showtime->start_time)->locale('fr')->isoFormat('dddd D MMMM YYYY') }}</div>
            </div>
        </div>
        
        <!-- Movie details -->
        <div class="flex items-center mb-4">
            <div class="w-16 h-24 bg-gray-200 rounded overflow-hidden mr-4 flex-shrink-0">
                @if($ticket->reservation->showtime->movie->image)
                    <img src="{{ $ticket->reservation->showtime->movie->image }}" alt="{{ $ticket->reservation->showtime->movie->title }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center">
                        <i class="fas fa-film text-gray-400 text-2xl"></i>
                    </div>
                @endif
            </div>
            <div class="text-sm text-gray-600">
                <div class="mb-1">Durée: {{ $ticket->reservation->showtime->movie->duration }} min</div>
                @if($ticket->reservation->showtime->movie->min_age > 0)
                    <div class="mb-1">
                        <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded">
                            {{ $ticket->reservation->showtime->movie->min_age }}+
                        </span>
                    </div>
                @endif
                <div>
                    <span class="px-2 py-1 rounded-full text-xs {{ $ticket->reservation->showtime->type == 'VIP' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800' }}">
                        {{ $ticket->reservation->showtime->type }}
                    </span>
                </div>
            </div>
        </div>
        
        <!-- Theater and seats -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <div class="text-sm font-semibold text-gray-800 mb-1">Salle</div>
                <div class="text-sm text-gray-600">{{ $ticket->reservation->showtime->theater->name }}</div>
            </div>
            <div>
                <div class="text-sm font-semibold text-gray-800 mb-1">Langue</div>
                <div class="text-sm text-gray-600">{{ $ticket->reservation->showtime->language }}</div>
            </div>
        </div>
        
        <!-- Seats -->
        <div class="mt-4">
            <div class="text-sm font-semibold text-gray-800 mb-2">Places</div>
            <div class="flex flex-wrap gap-2">
                @foreach($ticket->reservation->seats as $seat)
                    <div class="bg-gray-100 rounded px-3 py-1 text-sm flex items-center">
                        <span class="w-4 h-4 {{ $seat->type == 'Couple' ? 'bg-pink-300' : 'bg-gray-300' }} rounded-sm mr-2 flex-shrink-0"></span>
                        <span>Rangée {{ $seat->row }}, Siège {{ $seat->number }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    
    <!-- QR Code section -->
    <div class="p-6 text-center">
        <div class="inline-block bg-white p-3 rounded-lg border border-gray-300 mb-3">
            <div class="qr-code-container" data-ticket-number="{{ $ticket->ticket_number }}" style="width: 150px; height: 150px;"></div>
        </div>
        <div class="text-xs text-gray-500">
            Ce billet est personnel et non remboursable.<br>
            Veuillez vous présenter 15 minutes avant la séance.
        </div>
    </div>
</div>

@once
<script src="https://cdn.jsdelivr.net/npm/qrious@4.0.2/dist/qrious.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Generate QR code for each ticket
    document.querySelectorAll('.qr-code-container').forEach(container => {
        const ticketNumber = container.dataset.ticketNumber;
        
        new QRious({
            element: container.appendChild(document.createElement('canvas')),
            value: ticketNumber,
            size: 150,
            backgroundAlpha: 1,
            foreground: '#4f46e5',
            level: 'H' // High error correction
        });
    });
});
</script>
@endonce

@if($printable)
<style>
@media print {
    body * {
        visibility: hidden;
    }
    
    .ticket, .ticket * {
        visibility: visible;
    }
    
    .ticket {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
    }
    
    .no-print {
        display: none !important;
    }
}
</style>
@endif