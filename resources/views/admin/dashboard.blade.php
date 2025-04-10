@extends('layouts.admin')

@section('title', 'Tableau de bord - Administration CinéHall')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
        <h1 class="text-2xl font-semibold text-gray-900">Tableau de bord</h1>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
        <!-- Stats cards -->
        <div class="mt-6 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
            <!-- User count card -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                            <i class="fas fa-users text-white"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Utilisateurs
                                </dt>
                                <dd>
                                    <div class="text-lg font-medium text-gray-900">
                                        {{ $stats['user_count'] }}
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-4 sm:px-6">
                    <div class="text-sm">
                        <a href="{{ route('admin.users.index') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                            Voir tous les utilisateurs
                        </a>
                    </div>
                </div>
            </div>

            <!-- Movie count card -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                            <i class="fas fa-film text-white"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Films
                                </dt>
                                <dd>
                                    <div class="text-lg font-medium text-gray-900">
                                        {{ $stats['movie_count'] }}
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-4 sm:px-6">
                    <div class="text-sm">
                        <a href="{{ route('admin.movies.index') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                            Gérer les films
                        </a>
                    </div>
                </div>
            </div>

            <!-- Reservation count card -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                            <i class="fas fa-ticket-alt text-white"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Réservations
                                </dt>
                                <dd>
                                    <div class="text-lg font-medium text-gray-900">
                                        {{ $stats['reservation_count'] }} ({{ $stats['paid_reservation_count'] }} payées)
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-4 sm:px-6">
                    <div class="text-sm">
                        <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">
                            Voir toutes les réservations
                        </a>
                    </div>
                </div>
            </div>

            <!-- Total revenue card -->
            <div class="bg-white overflow-hidden shadow rounded-lg sm:col-span-2">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                            <i class="fas fa-euro-sign text-white"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Chiffre d'affaires total
                                </dt>
                                <dd>
                                    <div class="text-lg font-medium text-gray-900">
                                        {{ number_format($stats['total_revenue'], 2, ',', ' ') }} €
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-4 sm:px-6">
                    <div class="text-sm">
                        <a href="{{ route('admin.movie-revenue') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                            Voir le détail des revenus
                        </a>
                    </div>
                </div>
            </div>

            <!-- Showtime count card -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                            <i class="fas fa-clock text-white"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Séances
                                </dt>
                                <dd>
                                    <div class="text-lg font-medium text-gray-900">
                                        {{ $stats['showtime_count'] }}
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-4 sm:px-6">
                    <div class="text-sm">
                        <a href="{{ route('admin.showtimes.index') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                            Gérer les séances
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts -->
        <div class="mt-8 grid grid-cols-1 gap-8 lg:grid-cols-2">
            <!-- Movie revenue chart -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Revenus par film</h2>
                <div class="h-80">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>

            <!-- Popular movies chart -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Films les plus populaires</h2>
                <div class="h-80">
                    <canvas id="popularMoviesChart"></canvas>
                </div>
            </div>
            
            <!-- Occupancy rates table -->
            <div class="bg-white rounded-lg shadow lg:col-span-2">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Taux d'occupation des salles</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Film
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Salle
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date & Heure
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Capacité
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Places vendues
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Taux d'occupation
                                </th>
                            </tr>
                        </thead>
                        <tbody id="occupancy-table-body" class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                    Chargement des données...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="bg-gray-50 px-6 py-4">
                    <a href="{{ route('admin.occupancy-rates') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                        Voir tous les taux d'occupation
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Fetch movie revenue data
    fetch('{{ route("admin.movie-revenue") }}')
        .then(response => response.json())
        .then(data => {
            // Sort data by revenue (descending) and take top 5
            const topMovies = data.sort((a, b) => b.total_revenue - a.total_revenue).slice(0, 5);
            
            // Prepare data for chart
            const labels = topMovies.map(movie => movie.title);
            const revenues = topMovies.map(movie => movie.total_revenue);
            
            // Create chart
            const revenueCtx = document.getElementById('revenueChart').getContext('2d');
            new Chart(revenueCtx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Revenus (€)',
                        data: revenues,
                        backgroundColor: 'rgba(79, 70, 229, 0.8)',
                        borderColor: 'rgba(79, 70, 229, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return value.toLocaleString('fr-FR') + ' €';
                                }
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.raw.toLocaleString('fr-FR') + ' €';
                                }
                            }
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error fetching movie revenue:', error));
    
    // Fetch popular movies data
    fetch('{{ route("admin.popular-movies") }}')
        .then(response => response.json())
        .then(data => {
            // Sort data by tickets sold (descending) and take top 5
            const topMovies = data.sort((a, b) => b.tickets_sold - a.tickets_sold).slice(0, 5);
            
            // Prepare data for chart
            const labels = topMovies.map(movie => movie.title);
            const ticketsSold = topMovies.map(movie => movie.tickets_sold);
            
            // Create chart
            const popularCtx = document.getElementById('popularMoviesChart').getContext('2d');
            new Chart(popularCtx, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        data: ticketsSold,
                        backgroundColor: [
                            'rgba(79, 70, 229, 0.8)',
                            'rgba(59, 130, 246, 0.8)',
                            'rgba(16, 185, 129, 0.8)',
                            'rgba(245, 158, 11, 0.8)',
                            'rgba(239, 68, 68, 0.8)'
                        ],
                        borderColor: [
                            'rgba(79, 70, 229, 1)',
                            'rgba(59, 130, 246, 1)',
                            'rgba(16, 185, 129, 1)',
                            'rgba(245, 158, 11, 1)',
                            'rgba(239, 68, 68, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.label + ': ' + context.raw + ' tickets';
                                }
                            }
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error fetching popular movies:', error));
    
    // Fetch occupancy rates data
    fetch('{{ route("admin.occupancy-rates") }}')
        .then(response => response.json())
        .then(data => {
            // Sort data by occupancy rate (descending)
            const sortedData = data.sort((a, b) => b.occupancy_rate - a.occupancy_rate);
            
            // Get table body element
            const tableBody = document.getElementById('occupancy-table-body');
            
            // Clear loading message
            tableBody.innerHTML = '';
            
            // Create table rows
            sortedData.slice(0, 10).forEach(showtime => {
                const row = document.createElement('tr');
                
                // Format date and time
                const date = new Date(showtime.start_time);
                const formattedDate = date.toLocaleDateString('fr-FR');
                const formattedTime = date.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' });
                
                // Set row class based on occupancy rate
                if (showtime.occupancy_rate > 80) {
                    row.className = 'bg-green-50';
                } else if (showtime.occupancy_rate < 30) {
                    row.className = 'bg-red-50';
                }
                
                row.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        ${showtime.movie_title}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        ${showtime.theater_name}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        ${formattedDate} ${formattedTime}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        ${showtime.capacity}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        ${showtime.seats_sold}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <div class="flex items-center">
                            <div class="w-full bg-gray-200 rounded-full h-2.5 mr-2">
                                <div class="bg-indigo-600 h-2.5 rounded-full" style="width: ${showtime.occupancy_rate}%"></div>
                            </div>
                            <span class="text-gray-700">${showtime.occupancy_rate.toFixed(1)}%</span>
                        </div>
                    </td>
                `;
                
                tableBody.appendChild(row);
            });
        })
        .catch(error => {
            console.error('Error fetching occupancy rates:', error);
            document.getElementById('occupancy-table-body').innerHTML = `
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-sm text-red-500">
                        Erreur lors du chargement des données.
                    </td>
                </tr>
            `;
        });
});
</script>
@endpush