@props(['showtime', 'showMovie' => true, 'compact' => false])

<div {{ $attributes->merge(['class' => 'bg-white rounded-lg shadow-md showtime-card']) }}
    data-date="{{ \Carbon\Carbon::parse($showtime->start_time)->format('Y-m-d') }}"
    data-type="{{ $showtime->type }}"
    data-language="{{ $showtime->language }}">
    
    @if($compact)
        <!-- Compact version for lists -->
        <div class="p-4">
            <div class="flex justify-between items-start mb-3">
                <div>
                    <div class="text-lg font-semibold text-gray-800">
                        {{ \Carbon\Carbon::parse($showtime->start_time)->format('H:i') }}
                    </div>
                    <div class="text-sm text-gray-600">
                        {{ \Carbon\Carbon::parse($showtime->start_time)->locale('fr')->isoFormat('dddd D MMMM') }}
                    </div>
                </div>
                <span class="px-2 py-1 rounded-full text-xs font-medium {{ $showtime->type == 'VIP' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800' }}">
                    {{ $showtime->type }}
                </span>
            </div>
            
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-600">
                    <div>{{ $showtime->theater->name }}</div>
                    <div>{{ $showtime->language }}</div>
                </div>
                
                <a href="{{ route('reservations.create', $showtime->id) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded text-sm font-medium transition duration-300">
                    Réserver
                </a>
            </div>
        </div>
    @else
        <!-- Full version -->
        <div class="p-6">
            @if($showMovie)
                <div class="flex items-center mb-4">
                    <div class="h-16 w-12 bg-gray-300 rounded overflow-hidden mr-4 flex-shrink-0">
                        @if($showtime->movie->image)
                            <img src="{{ $showtime->movie->image }}" alt="{{ $showtime->movie->title }}" class="h-full w-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gray-200">
                                <i class="fas fa-film text-gray-400"></i>
                            </div>
                        @endif
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800">
                            <a href="{{ route('movies.show', $showtime->movie->id) }}" class="hover:text-indigo-600">
                                {{ $showtime->movie->title }}
                            </a>
                        </h3>
                        <div class="flex items-center text-sm text-gray-600 mt-1">
                            <span>{{ $showtime->movie->duration }} min</span>
                            @if($showtime->movie->min_age > 0)
                                <span class="mx-2">•</span>
                                <span class="bg-red-100 text-red-800 text-xs px-2 py-0.5 rounded">{{ $showtime->movie->min_age }}+</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
            
            <div class="flex justify-between items-start mb-4">
                <div>
                    <div class="text-lg font-semibold text-gray-800">
                        {{ \Carbon\Carbon::parse($showtime->start_time)->locale('fr')->isoFormat('dddd D MMMM') }}
                    </div>
                    <div class="text-indigo-600 font-bold">
                        {{ \Carbon\Carbon::parse($showtime->start_time)->format('H:i') }}
                    </div>
                </div>
                <span class="px-3 py-1 rounded-full text-xs font-medium {{ $showtime->type == 'VIP' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800' }}">
                    {{ $showtime->type }}
                </span>
            </div>
            
            <div class="text-sm text-gray-600 mb-4">
                <div class="flex items-center mb-2">
                    <i class="fas fa-map-marker-alt mr-2 text-indigo-600 w-5 text-center"></i>
                    <span>{{ $showtime->theater->name }}</span>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-language mr-2 text-indigo-600 w-5 text-center"></i>
                    <span>{{ $showtime->language }}</span>
                </div>
            </div>
            
            <div class="mt-4">
                <a href="{{ route('reservations.create', $showtime->id) }}" class="block w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded font-medium transition duration-300">
                    Réserver
                </a>
            </div>
        </div>
    @endif
</div>