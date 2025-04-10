@extends('layouts.app')

@section('title', 'Page non trouvée - CinéHall')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full text-center">
        <div class="text-6xl font-bold text-indigo-600 mb-4">404</div>
        <h1 class="text-3xl font-extrabold text-gray-900 mb-6">
            Page non trouvée
        </h1>
        <p class="text-lg text-gray-600 mb-8">
            Désolé, la page que vous recherchez n'existe pas ou a été déplacée.
        </p>
        <div class="space-y-4">
            <a href="{{ route('home') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <i class="fas fa-home mr-2"></i>
                Retour à l'accueil
            </a>
            <p class="text-sm text-gray-500 mt-6">
                Vous pouvez également consulter notre
                <a href="{{ route('movies.index') }}" class="text-indigo-600 hover:text-indigo-500">
                    liste de films
                </a>
                ou
                <a href="{{ route('showtimes.index') }}" class="text-indigo-600 hover:text-indigo-500">
                    nos séances disponibles
                </a>.
            </p>
        </div>
    </div>
</div>
@endsection