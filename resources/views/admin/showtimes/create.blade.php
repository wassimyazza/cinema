@extends('layouts.admin')

@section('title', 'Ajouter une séance - Administration CinéHall')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
        <div class="lg:flex lg:items-center lg:justify-between mb-6">
            <div class="flex-1 min-w-0">
                <h1 class="text-2xl font-semibold text-gray-900">Ajouter une nouvelle séance</h1>
                <p class="mt-1 text-sm text-gray-500">
                    Programmez une nouvelle séance de cinéma
                </p>
            </div>
            <div class="mt-5 flex lg:mt-0 lg:ml-4">
                <a href="{{ route('admin.showtimes.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Retour à la liste
                </a>
            </div>
        </div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
        <form action="{{ route('admin.showtimes.store') }}" method="POST" class="space-y-8">
            @csrf
            
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Informations de la séance
                    </h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">
                        Détails de la séance à programmer
                    </p>
                </div>
                <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        <div class="sm:col-span-3">
                            <label for="movie_id" class="block text-sm font-medium text-gray-700">Film</label>
                            <div class="mt-1">
                                <select id="movie_id" name="movie_id" required class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    <option value="">Sélectionner un film</option>
                                    @foreach($movies as $movie)
                                        <option value="{{ $movie->id }}" {{ old('movie_id') == $movie->id ? 'selected' : '' }}>
                                            {{ $movie->title }} ({{ $movie->duration }} min)
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('movie_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="sm:col-span-3">
                            <label for="theater_id" class="block text-sm font-medium text-gray-700">Salle</label>
                            <div class="mt-1">
                                <select id="theater_id" name="theater_id" required class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    <option value="">Sélectionner une salle</option>
                                    @foreach($theaters as $theater)
                                        <option value="{{ $theater->id }}" {{ old('theater_id') == $theater->id ? 'selected' : '' }}>
                                            {{ $theater->name }} ({{ $theater->type }} - {{ $theater->capacity }} places)
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('theater_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="sm:col-span-3">
                            <label for="start_date" class="block text-sm font-medium text-gray-700">Date</label>
                            <div class="mt-1">
                                <input type="date" name="start_date" id="start_date" value="{{ old('start_date') ?: date('Y-m-d') }}" required class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                            @error('start_date')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="sm:col-span-3">
                            <label for="start_time" class="block text-sm font-medium text-gray-700">Heure</label>
                            <div class="mt-1">
                                <input type="time" name="start_time" id="start_time" value="{{ old('start_time') ?: '20:00' }}" required class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                            @error('start_time')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="sm:col-span-3">
                            <label for="language" class="block text-sm font-medium text-gray-700">Langue</label>
                            <div class="mt-1">
                                <select id="language" name="language" required class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    <option value="Français" {{ old('language') == 'Français' ? 'selected' : '' }}>Français</option>
                                    <option value="Anglais" {{ old('language') == 'Anglais' ? 'selected' : '' }}>Anglais (VOST)</option>
                                    <option value="Espagnol" {{ old('language') == 'Espagnol' ? 'selected' : '' }}>Espagnol (VOST)</option>
                                    <option value="Version originale" {{ old('language') == 'Version originale' ? 'selected' : '' }}>Version originale (VOST)</option>
                                </select>
                            </div>
                            @error('language')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="sm:col-span-3">
                            <label for="type" class="block text-sm font-medium text-gray-700">Type de séance</label>
                            <div class="mt-1">
                                <select id="type" name="type" required class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    <option value="Normal" {{ old('type') == 'Normal' ? 'selected' : '' }}>Normal</option>
                                    <option value="VIP" {{ old('type') == 'VIP' ? 'selected' : '' }}>VIP</option>
                                </select>
                            </div>
                            @error('type')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Vérification de disponibilité
                    </h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">
                        Vérifiez que la salle est disponible à l'horaire sélectionné
                    </p>
                </div>
                <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                    <div id="availability-info" class="bg-gray-50 p-4 rounded-md">
                        <p class="text-sm text-gray-500">
                            Veuillez sélectionner un film, une salle, et un horaire pour vérifier la disponibilité.
                        </p>
                    </div>
                    
                    <div id="conflict-warning" class="mt-4 bg-red-50 p-4 rounded-md hidden">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-circle text-red-400"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Conflit d'horaire détecté</h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <p>La salle sélectionnée n'est pas disponible à l'horaire indiqué. Il y a déjà une séance programmée qui chevauche cet horaire.</p>
                                    <ul class="list-disc pl-5 mt-1 space-y-1" id="conflict-details">
                                        <!-- Les conflits seront ajoutés ici -->
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div id="available-confirmation" class="mt-4 bg-green-50 p-4 rounded-md hidden">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-check-circle text-green-400"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-green-800">Horaire disponible</h3>
                                <div class="mt-2 text-sm text-green-700">
                                    <p>La salle est disponible à l'horaire sélectionné. Vous pouvez créer cette séance.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <button type="button" id="check-availability" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <i class="fas fa-calendar-check mr-2"></i>
                            Vérifier la disponibilité
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="flex justify-end">
                <a href="{{ route('admin.showtimes.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Annuler
                </a>
                <button type="submit" id="submit-btn" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Ajouter la séance
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const movieSelect = document.getElementById('movie_id');
    const theaterSelect = document.getElementById('theater_id');
    const startDateInput = document.getElementById('start_date');
    const startTimeInput = document.getElementById('start_time');
    const checkAvailabilityBtn = document.getElementById('check-availability');
    const availabilityInfo = document.getElementById('availability-info');
    const conflictWarning = document.getElementById('conflict-warning');
    const availableConfirmation = document.getElementById('available-confirmation');
    const conflictDetails = document.getElementById('conflict-details');
    const submitBtn = document.getElementById('submit-btn');
    
    // Movie duration lookup table
    const movieDurations = {
        @foreach($movies as $movie)
            "{{ $movie->id }}": {{ $movie->duration }},
        @endforeach
    };
    
    // Check if all required fields are filled
    function areAllFieldsFilled() {
        return movieSelect.value && theaterSelect.value && startDateInput.value && startTimeInput.value;
    }
    
    // Format date and time for API request
    function formatDateTime() {
        return `${startDateInput.value}T${startTimeInput.value}:00`;
    }
    
    // Calculate end time based on movie duration
    function calculateEndDateTime() {
        if (!movieSelect.value || !startDateInput.value || !startTimeInput.value) return null;
        
        const movieId = movieSelect.value;
        const duration = movieDurations[movieId] || 120; // Default to 2 hours if unknown
        
        const startDateTime = new Date(`${startDateInput.value}T${startTimeInput.value}`);
        const endDateTime = new Date(startDateTime.getTime() + duration * 60000); // Convert minutes to milliseconds
        
        return endDateTime;
    }
    
    // Check availability against backend
    async function checkAvailability() {
        if (!areAllFieldsFilled()) {
            alert('Veuillez remplir tous les champs requis avant de vérifier la disponibilité.');
            return;
        }
        
        const movieId = movieSelect.value;
        const theaterId = theaterSelect.value;
        const startTime = formatDateTime();
        const endTime = calculateEndDateTime().toISOString();
        
        try {
            // Simulate API call - in real app, replace with actual API endpoint
            // const response = await fetch('/api/check-availability', {
            //     method: 'POST',
            //     headers: {
            //         'Content-Type': 'application/json',
            //         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            //     },
            //     body: JSON.stringify({
            //         theater_id: theaterId,
            //         start_time: startTime,
            //         end_time: endTime,
            //     })
            // });
            // const data = await response.json();
            
            // For demo purposes, we'll simulate the API response
            // In a real application, you would use the API response
            const isAvailable = await simulateAvailabilityCheck(theaterId, startTime, endTime);
            
            // Hide all availability info containers
            availabilityInfo.classList.add('hidden');
            conflictWarning.classList.add('hidden');
            availableConfirmation.classList.add('hidden');
            
            if (isAvailable.available) {
                // Show available confirmation
                availableConfirmation.classList.remove('hidden');
                submitBtn.disabled = false;
            } else {
                // Show conflict warning
                conflictWarning.classList.remove('hidden');
                
                // Clear previous conflict details
                conflictDetails.innerHTML = '';
                
                // Add conflict details
                isAvailable.conflicts.forEach(conflict => {
                    const li = document.createElement('li');
                    li.textContent = `${conflict.movie} - ${formatConflictDateTime(conflict.start_time)} à ${formatConflictDateTime(conflict.end_time)}`;
                    conflictDetails.appendChild(li);
                });
                
                // Disable submit button
                submitBtn.disabled = true;
            }
        } catch (error) {
            console.error('Error checking availability:', error);
            alert('Une erreur est survenue lors de la vérification de disponibilité. Veuillez réessayer.');
        }
    }
    
    // Simulate availability check (remove in real application)
    async function simulateAvailabilityCheck(theaterId, startTime, endTime) {
        // This is just a simulation, in a real app you would call your API
        const startDateTime = new Date(startTime);
        const endDateTime = new Date(endTime);
        
        // 80% chance of being available for demo purposes
        const isAvailable = Math.random() > 0.2;
        
        if (isAvailable) {
            return {
                available: true,
                conflicts: []
            };
        } else {
            // Generate a random conflict
            const conflictStart = new Date(startDateTime);
            conflictStart.setMinutes(conflictStart.getMinutes() - 30);
            
            const conflictEnd = new Date(startDateTime);
            conflictEnd.setMinutes(conflictEnd.getMinutes() + 120);
            
            return {
                available: false,
                conflicts: [
                    {
                        movie: "Film déjà programmé",
                        start_time: conflictStart.toISOString(),
                        end_time: conflictEnd.toISOString()
                    }
                ]
            };
        }
    }
    
    // Format date time for display
    function formatConflictDateTime(isoString) {
        const date = new Date(isoString);
        return date.toLocaleString('fr-FR', {
            hour: '2-digit',
            minute: '2-digit',
            day: '2-digit',
            month: '2-digit',
            year: 'numeric'
        });
    }
    
    // Event listener for check availability button
    checkAvailabilityBtn.addEventListener('click', checkAvailability);
    
    // Event listeners for form input changes
    movieSelect.addEventListener('change', function() {
        // Reset availability
        availabilityInfo.classList.remove('hidden');
        conflictWarning.classList.add('hidden');
        availableConfirmation.classList.add('hidden');
    });
    
    theaterSelect.addEventListener('change', function() {
        // Reset availability
        availabilityInfo.classList.remove('hidden');
        conflictWarning.classList.add('hidden');
        availableConfirmation.classList.add('hidden');
    });
    
    startDateInput.addEventListener('change', function() {
        // Reset availability
        availabilityInfo.classList.remove('hidden');
        conflictWarning.classList.add('hidden');
        availableConfirmation.classList.add('hidden');
    });
    
    startTimeInput.addEventListener('change', function() {
        // Reset availability
        availabilityInfo.classList.remove('hidden');
        conflictWarning.classList.add('hidden');
        availableConfirmation.classList.add('hidden');
    });
    
    // Form submission handling
    document.querySelector('form').addEventListener('submit', function(event) {
        // Get the selected movie duration
        const movieId = movieSelect.value;
        const movieDuration = movieDurations[movieId] || 120;
        
        // Create a hidden input for the full start_time (combining date and time)
        const startTimeFullInput = document.createElement('input');
        startTimeFullInput.type = 'hidden';
        startTimeFullInput.name = 'start_time';
        startTimeFullInput.value = `${startDateInput.value} ${startTimeInput.value}:00`;
        this.appendChild(startTimeFullInput);
        
        // We'll use the separate fields for validation but the combined value for saving
    });
});
</script>
@endpush