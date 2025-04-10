@extends('layouts.app')

@section('title', 'Mon Profil - CinéHall')

@section('content')
<div class="bg-gray-100 py-8">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto">
            <h1 class="text-3xl font-bold text-gray-800 mb-8">Mon Profil</h1>
            
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <!-- Profile tabs -->
                <div class="flex border-b border-gray-200">
                    <button class="tab-btn active py-4 px-6 font-medium text-gray-800 border-b-2 border-indigo-600 focus:outline-none" data-tab="profile-info">
                        Mes informations
                    </button>
                    <button class="tab-btn py-4 px-6 font-medium text-gray-500 hover:text-gray-800 border-b-2 border-transparent hover:border-gray-300 focus:outline-none" data-tab="password-change">
                        Changer de mot de passe
                    </button>
                    <button class="tab-btn py-4 px-6 font-medium text-gray-500 hover:text-gray-800 border-b-2 border-transparent hover:border-gray-300 focus:outline-none" data-tab="delete-account">
                        Supprimer mon compte
                    </button>
                </div>
                
                <!-- Profile info tab -->
                <div id="profile-info" class="tab-content p-6">
                    <form id="profile-form" method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nom complet</label>
                                <input type="text" id="name" name="name" value="{{ Auth::user()->name }}" class="block w-full py-2 px-3 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                @error('name')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Adresse email</label>
                                <input type="email" id="email" name="email" value="{{ Auth::user()->email }}" class="block w-full py-2 px-3 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                @error('email')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                                <input type="text" id="phone" name="phone" value="{{ Auth::user()->phone }}" class="block w-full py-2 px-3 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                @error('phone')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Adresse</label>
                                <textarea id="address" name="address" rows="3" class="block w-full py-2 px-3 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">{{ Auth::user()->address }}</textarea>
                                @error('address')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-md font-medium transition duration-300">
                                    Enregistrer les modifications
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                
                <!-- Password change tab -->
                <div id="password-change" class="tab-content p-6 hidden">
                    <form id="password-form" method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Mot de passe actuel</label>
                                <input type="password" id="current_password" name="current_password" class="block w-full py-2 px-3 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                @error('current_password')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Nouveau mot de passe</label>
                                <input type="password" id="password" name="password" class="block w-full py-2 px-3 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                @error('password')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirmer le nouveau mot de passe</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" class="block w-full py-2 px-3 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            
                            <div>
                                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-md font-medium transition duration-300">
                                    Changer le mot de passe
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                
                <!-- Delete account tab -->
                <div id="delete-account" class="tab-content p-6 hidden">
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-triangle text-red-600"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Attention - Action irréversible</h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <p>La suppression de votre compte est définitive et toutes vos données seront effacées, y compris l'historique de vos réservations et tickets.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <form id="delete-form" method="POST" action="{{ route('profile.destroy') }}">
                        @csrf
                        @method('DELETE')
                        
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label for="delete_password" class="block text-sm font-medium text-gray-700 mb-1">Saisissez votre mot de passe pour confirmer</label>
                                <input type="password" id="delete_password" name="password" class="block w-full py-2 px-3 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                @error('password')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <div class="flex items-start mb-4">
                                    <div class="flex items-center h-5">
                                        <input id="confirm_delete" name="confirm_delete" type="checkbox" class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="confirm_delete" class="font-medium text-gray-700">Je confirme vouloir supprimer mon compte</label>
                                    </div>
                                </div>
                                
                                <button type="submit" id="delete-btn" class="bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-md font-medium transition duration-300 disabled:bg-gray-400 disabled:cursor-not-allowed" disabled>
                                    Supprimer mon compte
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
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
    
    // Delete account form handling
    const confirmDeleteCheckbox = document.getElementById('confirm_delete');
    const deleteButton = document.getElementById('delete-btn');
    
    if (confirmDeleteCheckbox && deleteButton) {
        confirmDeleteCheckbox.addEventListener('change', function() {
            deleteButton.disabled = !this.checked;
        });
    }
    
    // Delete account form submission
    const deleteForm = document.getElementById('delete-form');
    
    if (deleteForm) {
        deleteForm.addEventListener('submit', function(e) {
            if (!confirmDeleteCheckbox.checked) {
                e.preventDefault();
                alert('Veuillez confirmer la suppression en cochant la case.');
                return;
            }
            
            if (!confirm('Êtes-vous vraiment sûr de vouloir supprimer votre compte ? Cette action est irréversible.')) {
                e.preventDefault();
            }
        });
    }
});
</script>
@endpush