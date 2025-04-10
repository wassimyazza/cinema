@extends('layouts.app')

@section('title', 'Erreur serveur - CinéHall')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full text-center">
        <div class="text-6xl font-bold text-red-600 mb-4">500</div>
        <h1 class="text-3xl font-extrabold text-gray-900 mb-6">
            Erreur interne du serveur
        </h1>
        <p class="text-lg text-gray-600 mb-8">
            Désolé, quelque chose s'est mal passé sur nos serveurs. Nous travaillons à résoudre le problème.
        </p>
        <div class="space-y-4">
            <a href="{{ route('home') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <i class="fas fa-home mr-2"></i>
                Retour à l'accueil
            </a>
            <p class="text-sm text-gray-500 mt-6">
                Si le problème persiste, n'hésitez pas à
                <a href="mailto:contact@cinehall.com" class="text-indigo-600 hover:text-indigo-500">
                    nous contacter
                </a>.
            </p>
        </div>
    </div>
</div>
@endsection