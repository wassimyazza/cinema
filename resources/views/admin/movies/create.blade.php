@extends('layouts.admin')

@section('title', 'Ajouter un film - Administration CinéHall')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
        <div class="lg:flex lg:items-center lg:justify-between mb-6">
            <div class="flex-1 min-w-0">
                <h1 class="text-2xl font-semibold text-gray-900">Ajouter un nouveau film</h1>
                <p class="mt-1 text-sm text-gray-500">
                    Créez un nouveau film dans le catalogue CinéHall
                </p>
            </div>
            <div class="mt-5 flex lg:mt-0 lg:ml-4">
                <a href="{{ route('admin.movies.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Retour à la liste
                </a>
            </div>
        </div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
        <form action="{{ route('admin.movies.store') }}" method="POST" class="space-y-8">
            @csrf
            
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Informations générales
                    </h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">
                        Détails essentiels du film
                    </p>
                </div>
                <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        <div class="sm:col-span-4">
                            <label for="title" class="block text-sm font-medium text-gray-700">Titre</label>
                            <div class="mt-1">
                                <input type="text" name="title" id="title" value="{{ old('title') }}" required class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                            @error('title')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="sm:col-span-6">
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <div class="mt-1">
                                <textarea id="description" name="description" rows="5" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">{{ old('description') }}</textarea>
                            </div>
                            @error('description')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="sm:col-span-3">
                            <label for="genre" class="block text-sm font-medium text-gray-700">Genre</label>
                            <div class="mt-1">
                                <select id="genre" name="genre" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    <option value="">Sélectionner un genre</option>
                                    <option value="Action" {{ old('genre') == 'Action' ? 'selected' : '' }}>Action</option>
                                    <option value="Comédie" {{ old('genre') == 'Comédie' ? 'selected' : '' }}>Comédie</option>
                                    <option value="Drame" {{ old('genre') == 'Drame' ? 'selected' : '' }}>Drame</option>
                                    <option value="Science-Fiction" {{ old('genre') == 'Science-Fiction' ? 'selected' : '' }}>Science-Fiction</option>
                                    <option value="Horreur" {{ old('genre') == 'Horreur' ? 'selected' : '' }}>Horreur</option>
                                    <option value="Animation" {{ old('genre') == 'Animation' ? 'selected' : '' }}>Animation</option>
                                    <option value="Aventure" {{ old('genre') == 'Aventure' ? 'selected' : '' }}>Aventure</option>
                                    <option value="Documentaire" {{ old('genre') == 'Documentaire' ? 'selected' : '' }}>Documentaire</option>
                                    <option value="Romance" {{ old('genre') == 'Romance' ? 'selected' : '' }}>Romance</option>
                                    <option value="Thriller" {{ old('genre') == 'Thriller' ? 'selected' : '' }}>Thriller</option>
                                </select>
                            </div>
                            @error('genre')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="sm:col-span-1">
                            <label for="duration" class="block text-sm font-medium text-gray-700">Durée (min)</label>
                            <div class="mt-1">
                                <input type="number" name="duration" id="duration" value="{{ old('duration') }}" min="1" required class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                            @error('duration')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="sm:col-span-1">
                            <label for="min_age" class="block text-sm font-medium text-gray-700">Âge minimum</label>
                            <div class="mt-1">
                                <input type="number" name="min_age" id="min_age" value="{{ old('min_age', 0) }}" min="0" required class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                            @error('min_age')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Médias et liens
                    </h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">
                        Images et vidéos du film
                    </p>
                </div>
                <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        <div class="sm:col-span-6">
                            <label for="image" class="block text-sm font-medium text-gray-700">URL de l'affiche</label>
                            <div class="mt-1">
                                <input type="url" name="image" id="image" value="{{ old('image') }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                            <p class="mt-2 text-sm text-gray-500">URL d'une image pour l'affiche du film</p>
                            @error('image')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="sm:col-span-6">
                            <label for="trailer_url" class="block text-sm font-medium text-gray-700">URL de la bande-annonce</label>
                            <div class="mt-1">
                                <input type="url" name="trailer_url" id="trailer_url" value="{{ old('trailer_url') }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                            <p class="mt-2 text-sm text-gray-500">Lien YouTube vers la bande-annonce du film</p>
                            @error('trailer_url')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="flex justify-end">
                <a href="{{ route('admin.movies.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Annuler
                </a>
                <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Ajouter le film
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Preview trailer URL if provided
    const trailerUrlInput = document.getElementById('trailer_url');
    const imageInput = document.getElementById('image');
    
    if (trailerUrlInput) {
        trailerUrlInput.addEventListener('change', function() {
            validateYouTubeUrl(this.value);
        });
        
        // Initial validation if URL already exists
        if (trailerUrlInput.value) {
            validateYouTubeUrl(trailerUrlInput.value);
        }
    }
    
    function validateYouTubeUrl(url) {
        if (!url) return;
        
        // Simple validation for YouTube URL
        const youtubeRegex = /^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.?be)\/.+$/;
        
        if (!youtubeRegex.test(url)) {
            // Add error message
            let errorMessage = document.getElementById('trailer-error');
            if (!errorMessage) {
                errorMessage = document.createElement('p');
                errorMessage.id = 'trailer-error';
                errorMessage.className = 'mt-2 text-sm text-red-600';
                trailerUrlInput.parentNode.appendChild(errorMessage);
            }
            errorMessage.textContent = "L'URL doit être un lien YouTube valide";
        } else {
            // Remove error message if exists
            const errorMessage = document.getElementById('trailer-error');
            if (errorMessage) {
                errorMessage.remove();
            }
        }
    }
});
</script>
@endpush