<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Administration - CinéHall')</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    
    <!-- Custom Styles -->
    <style>
        @media (min-width: 768px) {
            .md\:translate-x-0 {
                transform: translateX(0);
            }
        }
    </style>
    
    <!-- Extra Styles -->
    @stack('styles')
</head>
<body class="bg-gray-100 h-screen flex overflow-hidden">
    <!-- Off-canvas menu for mobile, show/hide based on off-canvas menu state. -->
    <div id="mobile-sidebar" class="fixed inset-0 flex z-40 md:hidden" role="dialog" aria-modal="true" style="display: none;">
        <div class="fixed inset-0 bg-gray-600 bg-opacity-75" aria-hidden="true" id="sidebar-overlay"></div>
        
        <div id="mobile-sidebar-container" class="relative flex-1 flex flex-col max-w-xs w-full bg-indigo-800 transform transition ease-in-out duration-300 -translate-x-full">
            <div class="absolute top-0 right-0 -mr-12 pt-2">
                <button id="close-sidebar-btn" type="button" class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                    <span class="sr-only">Fermer le menu</span>
                    <i class="fas fa-times text-white"></i>
                </button>
            </div>
            
            <div class="flex-1 h-0 pt-5 pb-4 overflow-y-auto">
                <div class="flex-shrink-0 flex items-center px-4">
                    <a href="{{ route('admin.dashboard') }}" class="text-2xl font-bold text-white flex items-center">
                        <i class="fas fa-film mr-2"></i>
                        CinéHall Admin
                    </a>
                </div>
                <nav class="mt-8 px-2 space-y-1">
                    <!-- Mobile navigation links -->
                    <a href="{{ route('admin.dashboard') }}" class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-900 text-white' : 'text-indigo-100 hover:bg-indigo-700' }}">
                        <i class="fas fa-chart-line mr-3 text-indigo-300"></i>
                        Tableau de bord
                    </a>
                    
                    <a href="{{ route('admin.movies.index') }}" class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('admin.movies.*') ? 'bg-indigo-900 text-white' : 'text-indigo-100 hover:bg-indigo-700' }}">
                        <i class="fas fa-film mr-3 text-indigo-300"></i>
                        Films
                    </a>
                    
                    <a href="{{ route('admin.showtimes.index') }}" class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('admin.showtimes.*') ? 'bg-indigo-900 text-white' : 'text-indigo-100 hover:bg-indigo-700' }}">
                        <i class="fas fa-clock mr-3 text-indigo-300"></i>
                        Séances
                    </a>
                    
                    <a href="{{ route('admin.theaters.index') }}" class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('admin.theaters.*') ? 'bg-indigo-900 text-white' : 'text-indigo-100 hover:bg-indigo-700' }}">
                        <i class="fas fa-building mr-3 text-indigo-300"></i>
                        Salles
                    </a>
                    
                    <a href="{{ route('admin.users.index') }}" class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('admin.users.*') ? 'bg-indigo-900 text-white' : 'text-indigo-100 hover:bg-indigo-700' }}">
                        <i class="fas fa-users mr-3 text-indigo-300"></i>
                        Utilisateurs
                    </a>
                    
                    <a href="{{ route('admin.occupancy-rates') }}" class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('admin.occupancy-rates') ? 'bg-indigo-900 text-white' : 'text-indigo-100 hover:bg-indigo-700' }}">
                        <i class="fas fa-chart-pie mr-3 text-indigo-300"></i>
                        Taux d'occupation
                    </a>
                    
                    <a href="{{ route('admin.movie-revenue') }}" class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('admin.movie-revenue') ? 'bg-indigo-900 text-white' : 'text-indigo-100 hover:bg-indigo-700' }}">
                        <i class="fas fa-euro-sign mr-3 text-indigo-300"></i>
                        Revenus
                    </a>
                </nav>
            </div>
            <div class="flex-shrink-0 flex border-t border-indigo-700 p-4">
                <div class="flex-shrink-0 group block">
                    <div class="flex items-center">
                        <div class="ml-3">
                            <p class="text-base font-medium text-white">{{ Auth::user()->name }}</p>
                            <p class="text-sm font-medium text-indigo-200">Administrateur</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Static sidebar for desktop -->
    <div class="hidden md:flex md:flex-shrink-0">
        <div class="flex flex-col w-64">
            <div class="flex-1 flex flex-col min-h-0 bg-indigo-800">
                <div class="flex-1 flex flex-col pt-5 pb-4 overflow-y-auto">
                    <div class="flex items-center flex-shrink-0 px-4">
                        <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold text-white flex items-center">
                            <i class="fas fa-film mr-2"></i>
                            CinéHall Admin
                        </a>
                    </div>
                    <nav class="mt-8 flex-1 px-2 space-y-1">
                        <!-- Desktop navigation links (same as mobile) -->
                        <a href="{{ route('admin.dashboard') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-900 text-white' : 'text-indigo-100 hover:bg-indigo-700' }}">
                            <i class="fas fa-chart-line mr-3 text-indigo-300"></i>
                            Tableau de bord
                        </a>
                        
                        <a href="{{ route('admin.movies.index') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.movies.*') ? 'bg-indigo-900 text-white' : 'text-indigo-100 hover:bg-indigo-700' }}">
                            <i class="fas fa-film mr-3 text-indigo-300"></i>
                            Films
                        </a>
                        
                        <a href="{{ route('admin.showtimes.index') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.showtimes.*') ? 'bg-indigo-900 text-white' : 'text-indigo-100 hover:bg-indigo-700' }}">
                            <i class="fas fa-clock mr-3 text-indigo-300"></i>
                            Séances
                        </a>
                        
                        <a href="{{ route('admin.theaters.index') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.theaters.*') ? 'bg-indigo-900 text-white' : 'text-indigo-100 hover:bg-indigo-700' }}">
                            <i class="fas fa-building mr-3 text-indigo-300"></i>
                            Salles
                        </a>
                        
                        <a href="{{ route('admin.users.index') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.users.*') ? 'bg-indigo-900 text-white' : 'text-indigo-100 hover:bg-indigo-700' }}">
                            <i class="fas fa-users mr-3 text-indigo-300"></i>
                            Utilisateurs
                        </a>
                        
                        <a href="{{ route('admin.occupancy-rates') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.occupancy-rates') ? 'bg-indigo-900 text-white' : 'text-indigo-100 hover:bg-indigo-700' }}">
                            <i class="fas fa-chart-pie mr-3 text-indigo-300"></i>
                            Taux d'occupation
                        </a>
                        
                        <a href="{{ route('admin.movie-revenue') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.movie-revenue') ? 'bg-indigo-900 text-white' : 'text-indigo-100 hover:bg-indigo-700' }}">
                            <i class="fas fa-euro-sign mr-3 text-indigo-300"></i>
                            Revenus
                        </a>
                    </nav>
                </div>
                <div class="flex-shrink-0 flex border-t border-indigo-700 p-4">
                    <div class="flex-shrink-0 w-full group block">
                        <div class="flex items-center">
                            <div>
                                <i class="fas fa-user-circle text-indigo-300 text-2xl"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-white">{{ Auth::user()->name }}</p>
                                <div class="flex items-center">
                                    <p class="text-xs font-medium text-indigo-200 mr-2">Administrateur</p>
                                    <a href="{{ route('home') }}" class="text-xs text-indigo-100 hover:text-white" title="Voir le site">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="flex flex-col w-0 flex-1 overflow-hidden">
        <div class="md:hidden pl-1 pt-1 sm:pl-3 sm:pt-3">
            <button id="open-sidebar-btn" class="-ml-0.5 -mt-0.5 h-12 w-12 inline-flex items-center justify-center rounded-md text-gray-500 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                <span class="sr-only">Ouvrir le menu</span>
                <i class="fas fa-bars text-gray-400 text-2xl"></i>
            </button>
        </div>
        
        <main class="flex-1 relative overflow-y-auto focus:outline-none">
            <!-- Flash Messages -->
            @if(session('success') || session('error') || session('warning') || session('info'))
                <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8 mt-4">
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
            
            @yield('content')
        </main>
    </div>
</div>

<!-- Scripts -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mobile sidebar toggle
    const openSidebarBtn = document.getElementById('open-sidebar-btn');
    const closeSidebarBtn = document.getElementById('close-sidebar-btn');
    const sidebarOverlay = document.getElementById('sidebar-overlay');
    const mobileSidebar = document.getElementById('mobile-sidebar');
    const mobileSidebarContainer = document.getElementById('mobile-sidebar-container');
    
    openSidebarBtn.addEventListener('click', function() {
        mobileSidebar.style.display = 'flex';
        setTimeout(() => {
            mobileSidebarContainer.classList.remove('-translate-x-full');
            mobileSidebarContainer.classList.add('translate-x-0');
        }, 10);
    });
    
    function closeSidebar() {
        mobileSidebarContainer.classList.remove('translate-x-0');
        mobileSidebarContainer.classList.add('-translate-x-full');
        setTimeout(() => {
            mobileSidebar.style.display = 'none';
        }, 300);
    }
    
    closeSidebarBtn.addEventListener('click', closeSidebar);
    sidebarOverlay.addEventListener('click', closeSidebar);
    
    // Alert close buttons
    document.querySelectorAll('.alert-close').forEach(function(button) {
        button.addEventListener('click', function() {
            this.parentElement.remove();
        });
    });
});
</script>

<!-- Extra Scripts -->
@stack('scripts')
</body>
</html>