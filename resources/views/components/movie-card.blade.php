@props(['movie', 'showActions' => true])

<div {{ $attributes->merge(['class' => 'bg-white rounded-lg shadow-md overflow-hidden movie-card']) }} data-genre="{{ $movie->genre }}">
    <a href="{{ route('movies.show', $movie->id) }}" class="block">
        <div class="h-64 bg-gray-300 overflow-hidden">
            @if($movie->image)
                <img src="{{ $movie->image }}" alt="{{ $movie->title }}" class="w-full h-full object-cover movie-poster transition-transform duration-300 hover:scale-105">
            @else
                <div class="w-full h-full flex items-center justify-center bg-gray-200">
                    <i class="fas fa-film text-gray-400 text-5xl"></i>
                </div>
            @endif
        </div>
    </a>
    <div class="p-4">
        <div class="flex justify-between items-start">
            <h3 class="text-lg font-semibold text-gray-800">
                <a href="{{ route('movies.show', $movie->id) }}" class="hover:text-indigo-600">
                    {{ $movie->title }}
                </a>
            </h3>
            <span class="bg-indigo-100 text-indigo-800 text-xs px-2 py-1 rounded">
                {{ $movie->duration }} min
            </span>
        </div>
        
        <div class="flex items-center mt-2 text-sm text-gray-600">
            @if($movie->min_age > 0)
                <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded mr-2">
                    {{ $movie->min_age }}+
                </span>
            @endif
            @if($movie->genre)
                <span>{{ $movie->genre }}</span>
            @endif
        </div>
        
        @if(isset($slot) && !empty(trim($slot)))
            <div class="mt-3">
                {{ $slot }}
            </div>
        @else
            @if($showActions)
                <div class="mt-4 flex space-x-2">
                    <a href="{{ route('movies.show', $movie->id) }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 py-2 px-4 rounded text-sm inline-block transition duration-300">
                        Détails
                    </a>
                    <a href="{{ route('showtimes.by-movie', $movie->id) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded text-sm inline-block transition duration-300">
                        Réserver
                    </a>
                </div>
            @endif
        @endif
    </div>
</div>