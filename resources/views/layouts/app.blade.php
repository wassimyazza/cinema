<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'CinéHall - Votre cinéma en ligne')</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    
    <!-- Custom Styles -->
    <style>
        .movie-poster {
            transition: transform 0.3s ease;
        }
        .movie-poster:hover {
            transform: scale(1.05);
        }
        
        /* Seat map styling */
        .seat {
            transition: all 0.2s ease;
        }
        .seat-available {
            @apply bg-gray-300 hover:bg-blue-400 cursor-pointer;
        }
        .seat-selected {
            @apply bg-blue-500 text-white;
        }
        .seat-occupied {
            @apply bg-gray-600 text-white cursor-not-allowed;
        }
        .seat-couple {
            @apply bg-pink-300 hover:bg-pink-400;
        }
        .seat-couple.seat-selected {
            @apply bg-pink-500;
        }

        /* Hero section background */
        .hero-section {
            background-image: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
        }
    </style>
    
    <!-- Extra Styles -->
    @stack('styles')
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
    <header class="bg-indigo-900 text-white shadow-md">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <a href="{{ route('home') }}" class="text-2xl font-bold flex items-center">
                <i class="fas fa-film mr-2"></i>
                CinéHall
            </a>
            <nav class="hidden md:flex space-x-4">
                <a href="{{ route('home') }}" class="hover:text-indigo-200">Accueil</a>
                <a href="{{ route('movies.index') }}" class="hover:text-indigo-200">Films</a>
                <a href="{{ route('showtimes.index') }}" class="hover:text-indigo-200">Séances</a>
                
                @auth
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('reservations.index') }}" class="hover:text-indigo-200">Mes Réservations</a>
                        <div class="relative group">
                            <button class="flex items-center hover:text-indigo-200">
                                <span>{{ Auth::user()->name }}</span>
                                <i class="fas fa-chevron-down ml-1 text-xs"></i>
                            </button>
                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 hidden group-hover:block">
                                <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-100">
                                    Mon Profil
                                </a>
                                <a href="{{ route('tickets.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-100">
                                    Mes Billets
                                </a>
                                @if(Auth::user()->is_admin)
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-100">
                                        Administration
                                    </a>
                                @endif
                                <hr class="my-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-indigo-100">
                                        Déconnexion
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="space-x-4">
                        <a href="{{ route('login') }}" class="hover:text-indigo-200">Connexion</a>
                        <a href="{{ route('register') }}" class="hover:text-indigo-200">Inscription</a>
                    </div>
                @endauth
            </nav>
            
            <button id="mobile-menu-btn" class="md:hidden text-white">
                <i class="fas fa-bars"></i>
            </button>
        </div>
        
        <!-- Mobile menu, hidden by default -->
        <div id="mobile-menu" class="md:hidden hidden bg-indigo-800 pb-4">
            <div class="px-4 py-2 space-y-2">
                <a href="{{ route('home') }}" class="block hover:text-indigo-200">Accueil</a>
                <a href="{{ route('movies.index') }}" class="block hover:text-indigo-200">Films</a>
                <a href="{{ route('showtimes.index') }}" class="block hover:text-indigo-200">Séances</a>
                
                @auth
                    <a href="{{ route('reservations.index') }}" class="block hover:text-indigo-200">Mes Réservations</a>
                    <a href="{{ route('tickets.index') }}" class="block hover:text-indigo-200">Mes Billets</a>
                    <a href="{{ route('profile.show') }}" class="block hover:text-indigo-200">Mon Profil</a>
                    
                    @if(Auth::user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}" class="block hover:text-indigo-200">Administration</a>
                    @endif
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left hover:text-indigo-200 py-2">
                            Déconnexion
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block hover:text-indigo-200">Connexion</a>
                    <a href="{{ route('register') }}" class="block hover:text-indigo-200">Inscription</a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Flash Messages -->
    @if(session('success') || session('error') || session('warning') || session('info'))
        <div class="container mx-auto px-4 py-2">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Succès!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                    <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3 alert-close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Erreur!</strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                    <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3 alert-close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            @if(session('warning'))
                <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Attention!</strong>
                    <span class="block sm:inline">{{ session('warning') }}</span>
                    <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3 alert-close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            @if(session('info'))
                <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Information:</strong>
                    <span class="block sm:inline">{{ session('info') }}</span>
                    <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3 alert-close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif
        </div>
    @endif

    <main class="flex-grow">
        @yield('content')
    </main>

    <footer class="bg-gray-800 text-white py-8">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between">
                <div class="mb-6 md:mb-0">
                    <h2 class="text-xl font-bold mb-4">CinéHall</h2>
                    <p>Votre cinéma en ligne avec réservation de places</p>
                </div>
                <div class="mb-6 md:mb-0">
                    <h3 class="text-lg font-semibold mb-3">Liens Rapides</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="hover:text-indigo-300">Accueil</a></li>
                        <li><a href="{{ route('movies.index') }}" class="hover:text-indigo-300">Films</a></li>
                        <li><a href="{{ route('showtimes.index') }}" class="hover:text-indigo-300">Séances</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-3">Nous Contacter</h3>
                    <ul class="space-y-2">
                        <li><i class="fas fa-envelope mr-2"></i> contact@cinehall.com</li>
                        <li><i class="fas fa-phone mr-2"></i> +33 1 23 45 67 89</li>
                        <li><i class="fas fa-map-marker-alt mr-2"></i> 123 Rue du Cinéma, 75000 Paris</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-6 text-center">
                <p>&copy; {{ date('Y') }} CinéHall. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-btn').addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });
        
        // Alert close buttons
        document.querySelectorAll('.alert-close').forEach(function(button) {
            button.addEventListener('click', function() {
                this.parentElement.remove();
            });
        });
    </script>
    
    <!-- Extra Scripts -->
    @stack('scripts')
</body>
</html>