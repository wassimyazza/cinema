@extends('layouts.app')

@section('title', 'Mes Billets - CinéHall')

@section('content')
<div class="bg-gray-100 py-8">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Mes Billets</h1>
        
        @if(count($tickets) > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($tickets as $ticket)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="p-6 border-b border-gray-200">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h2 class="text-xl font-bold text-gray-800">{{ $ticket->reservation->showtime->movie->title }}</h2>
                                    <div class="mt-1 text-gray-600">
                                        {{ \Carbon\Carbon::parse($ticket->reservation->showtime->start_time)->format('d/m/Y H:i') }}
                                    </div>
                                </div>
                                <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">
                                    Payé
                                </span>
                            </div>
                            
                            <div class="mt-4 flex items-center text-sm text-gray-600">
                                <i class="fas fa-map-marker-alt text-indigo-600 mr-2"></i>
                                <span>{{ $ticket->reservation->showtime->theater->name }}</span>
                                <span class="mx-2">•</span>
                                <span>{{ $ticket->reservation->showtime->type }}</span>
                                <span class="mx-2">•</span>
                                <span>{{ $ticket->reservation->showtime->language }}</span>
                            </div>
                            
                            <div class="mt-3 flex items-center text-sm text-gray-600">
                                <i class="fas fa-ticket-alt text-indigo-600 mr-2"></i>
                                <span>{{ count($ticket->reservation->seats) }} {{ count($ticket->reservation->seats) > 1 ? 'places' : 'place' }}</span>
                            </div>
                        </div>
                        
                        <div class="p-4 bg-gray-50 flex justify-between items-center">
                            <div class="text-sm text-gray-600">
                                <span>N° {{ $ticket->ticket_number }}</span>
                            </div>
                            <div class="flex space-x-2">
                                <a href="{{ route('tickets.show', $ticket->id) }}" class="inline-flex items-center px-3 py-1 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150">
                                    <i class="fas fa-eye mr-1"></i> Voir
                                </a>
                                <a href="{{ route('tickets.download', $ticket->id) }}" class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition ease-in-out duration-150">
                                    <i class="fas fa-download mr-1"></i> Télécharger
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination if needed -->
            @if($tickets->hasPages())
                <div class="mt-6">
                    {{ $tickets->links() }}
                </div>
            @endif
            
        @else
            <div class="bg-white rounded-lg shadow-md p-8 text-center">
                <div class="w-16 h-16 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-ticket-alt text-gray-400 text-xl"></i>
                </div>
                <h2 class="text-xl font-bold text-gray-800 mb-2">Aucun billet trouvé</h2>
                <p class="text-gray-600 mb-6">Vous n'avez pas encore acheté de billets.</p>
                <a href="{{ route('movies.index') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-6 rounded-md font-medium transition duration-300">
                    Voir les films
                </a>
            </div>
        @endif
        
        <!-- Quick actions -->
        <div class="mt-8 flex justify-center">
            <a href="{{ route('reservations.index') }}" class="text-indigo-600 hover:text-indigo-800 font-medium flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>
                Voir mes réservations
            </a>
        </div>
    </div>
</div>
@endsection