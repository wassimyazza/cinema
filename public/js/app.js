// API Base URL
const API_BASE_URL = 'http://localhost:8000/api';

// DOM Elements
const contentDiv = document.getElementById('content');

// Load Movies
async function loadMovies() {
    try {
        const response = await fetch(`${API_BASE_URL}/movies`);
        const movies = await response.json();
        
        let html = '<div class="grid grid-cols-1 md:grid-cols-3 gap-6">';
        movies.forEach(movie => {
            html += `
                <div class="bg-white rounded-lg shadow-md p-4">
                    <img src="${movie.poster_url}" alt="${movie.title}" class="w-full h-64 object-cover rounded-t-lg">
                    <h2 class="text-xl font-bold mt-4">${movie.title}</h2>
                    <p class="text-gray-600">${movie.description}</p>
                    <p class="text-blue-600 font-semibold mt-2">Duration: ${movie.duration} minutes</p>
                    <button onclick="loadMovieShowtimes(${movie.id})" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        View Showtimes
                    </button>
                </div>
            `;
        });
        html += '</div>';
        contentDiv.innerHTML = html;
    } catch (error) {
        console.error('Error loading movies:', error);
        contentDiv.innerHTML = '<p class="text-red-500">Error loading movies. Please try again later.</p>';
    }
}

// Load Showtimes for a Movie
async function loadMovieShowtimes(movieId) {
    try {
        const response = await fetch(`${API_BASE_URL}/showtimes/movie/${movieId}`);
        const showtimes = await response.json();
        
        let html = '<div class="grid grid-cols-1 gap-4">';
        showtimes.forEach(showtime => {
            html += `
                <div class="bg-white rounded-lg shadow-md p-4">
                    <h3 class="text-lg font-semibold">${new Date(showtime.start_time).toLocaleString()}</h3>
                    <p class="text-gray-600">Theater: ${showtime.theater.name}</p>
                    <p class="text-gray-600">Type: ${showtime.type}</p>
                    <button onclick="loadSeats(${showtime.id})" class="mt-2 bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                        Book Seats
                    </button>
                </div>
            `;
        });
        html += '</div>';
        contentDiv.innerHTML = html;
    } catch (error) {
        console.error('Error loading showtimes:', error);
        contentDiv.innerHTML = '<p class="text-red-500">Error loading showtimes. Please try again later.</p>';
    }
}

// Load Available Seats
async function loadSeats(showtimeId) {
    try {
        const response = await fetch(`${API_BASE_URL}/seats/available/${showtimeId}`);
        const seats = await response.json();
        
        let html = '<div class="max-w-2xl mx-auto">';
        html += '<h2 class="text-2xl font-bold mb-4">Available Seats</h2>';
        html += '<div class="grid grid-cols-8 gap-2">';
        
        seats.forEach(seat => {
            html += `
                <div class="bg-green-500 text-white p-4 text-center rounded cursor-pointer hover:bg-green-600"
                     onclick="selectSeat(${seat.id}, ${showtimeId})">
                    ${seat.seat_number}
                </div>
            `;
        });
        
        html += '</div></div>';
        contentDiv.innerHTML = html;
    } catch (error) {
        console.error('Error loading seats:', error);
        contentDiv.innerHTML = '<p class="text-red-500">Error loading seats. Please try again later.</p>';
    }
}

// Select Seat and Create Reservation
async function selectSeat(seatId, showtimeId) {
    try {
        const response = await fetch(`${API_BASE_URL}/reservations`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                seat_id: seatId,
                showtime_id: showtimeId
            })
        });
        
        if (response.ok) {
            const reservation = await response.json();
            alert('Reservation successful! Your reservation ID is: ' + reservation.id);
            loadReservations();
        } else {
            throw new Error('Failed to create reservation');
        }
    } catch (error) {
        console.error('Error creating reservation:', error);
        alert('Error creating reservation. Please try again.');
    }
}

// Load User's Reservations
async function loadReservations() {
    try {
        const response = await fetch(`${API_BASE_URL}/reservations`);
        const reservations = await response.json();
        
        let html = '<div class="grid grid-cols-1 gap-4">';
        reservations.forEach(reservation => {
            html += `
                <div class="bg-white rounded-lg shadow-md p-4">
                    <h3 class="text-lg font-semibold">Reservation #${reservation.id}</h3>
                    <p class="text-gray-600">Movie: ${reservation.showtime.movie.title}</p>
                    <p class="text-gray-600">Showtime: ${new Date(reservation.showtime.start_time).toLocaleString()}</p>
                    <p class="text-gray-600">Seat: ${reservation.seat.seat_number}</p>
                    <button onclick="downloadTicket(${reservation.id})" class="mt-2 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Download Ticket
                    </button>
                </div>
            `;
        });
        html += '</div>';
        contentDiv.innerHTML = html;
    } catch (error) {
        console.error('Error loading reservations:', error);
        contentDiv.innerHTML = '<p class="text-red-500">Error loading reservations. Please try again later.</p>';
    }
}

// Download Ticket
async function downloadTicket(reservationId) {
    try {
        const response = await fetch(`${API_BASE_URL}/tickets/reservation/${reservationId}`);
        const ticket = await response.json();
        
        // Create a download link
        const downloadLink = document.createElement('a');
        downloadLink.href = `${API_BASE_URL}/tickets/${ticket.id}/download`;
        downloadLink.download = `ticket-${ticket.id}.pdf`;
        document.body.appendChild(downloadLink);
        downloadLink.click();
        document.body.removeChild(downloadLink);
    } catch (error) {
        console.error('Error downloading ticket:', error);
        alert('Error downloading ticket. Please try again.');
    }
}

// Load movies by default when page loads
document.addEventListener('DOMContentLoaded', loadMovies); 