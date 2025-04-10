<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Authentification - CinéHall')</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    
    <!-- Custom Styles -->
    <style>
        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif;
        }
    </style>
    
    <!-- Extra Styles -->
    @stack('styles')
</head>
<body>
    <main>
        @yield('content')
    </main>
    
    <footer class="mt-8 text-center text-sm text-gray-500">
        <p>&copy; {{ date('Y') }} CinéHall. Tous droits réservés.</p>
        <div class="mt-2">
            <a href="{{ route('home') }}" class="text-gray-500 hover:text-gray-700">Accueil</a> |
            <a href="#" class="text-gray-500 hover:text-gray-700">Conditions d'utilisation</a> |
            <a href="#" class="text-gray-500 hover:text-gray-700">Confidentialité</a> |
            <a href="#" class="text-gray-500 hover:text-gray-700">Contact</a>
        </div>
    </footer>
    
    <!-- Scripts -->
    @stack('scripts')
</body>
</html>