const API_BASE_URL = 'http://localhost:8000/api';

// Auth API
export const authAPI = {
    login: async (email, password) => {
        const response = await fetch(`${API_BASE_URL}/login`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ email, password })
        });
        return response.json();
    },

    register: async (userData) => {
        const response = await fetch(`${API_BASE_URL}/register`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(userData)
        });
        return response.json();
    },

    getProfile: async () => {
        const response = await fetch(`${API_BASE_URL}/me`, {
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('token')}`
            }
        });
        return response.json();
    },

    updateProfile: async (userData) => {
        const response = await fetch(`${API_BASE_URL}/profile`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('token')}`
            },
            body: JSON.stringify(userData)
        });
        return response.json();
    },

    deleteAccount: async () => {
        const response = await fetch(`${API_BASE_URL}/account`, {
            method: 'DELETE',
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('token')}`
            }
        });
        return response.json();
    }
};

// Movies API
export const moviesAPI = {
    getAll: async () => {
        const response = await fetch(`${API_BASE_URL}/movies`);
        return response.json();
    },

    getById: async (id) => {
        const response = await fetch(`${API_BASE_URL}/movies/${id}`);
        return response.json();
    },

    getPopular: async () => {
        const response = await fetch(`${API_BASE_URL}/popular-movies`, {
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('token')}`
            }
        });
        return response.json();
    },

    getRevenue: async () => {
        const response = await fetch(`${API_BASE_URL}/movie-revenue`, {
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('token')}`
            }
        });
        return response.json();
    }
};

// Showtimes API
export const showtimesAPI = {
    getAll: async () => {
        const response = await fetch(`${API_BASE_URL}/showtimes`);
        return response.json();
    },

    getByMovie: async (movieId) => {
        const response = await fetch(`${API_BASE_URL}/showtimes/movie/${movieId}`);
        return response.json();
    },

    getById: async (id) => {
        const response = await fetch(`${API_BASE_URL}/showtimes/${id}`);
        return response.json();
    },

    getOccupancyRates: async () => {
        const response = await fetch(`${API_BASE_URL}/occupancy-rates`, {
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('token')}`
            }
        });
        return response.json();
    }
};

// Reservations API
export const reservationsAPI = {
    create: async (reservationData) => {
        const response = await fetch(`${API_BASE_URL}/reservations`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('token')}`
            },
            body: JSON.stringify(reservationData)
        });
        return response.json();
    },

    getAll: async () => {
        const response = await fetch(`${API_BASE_URL}/reservations`, {
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('token')}`
            }
        });
        return response.json();
    },

    getById: async (id) => {
        const response = await fetch(`${API_BASE_URL}/reservations/${id}`, {
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('token')}`
            }
        });
        return response.json();
    }
};

// Seats API
export const seatsAPI = {
    getAvailable: async (showtimeId) => {
        const response = await fetch(`${API_BASE_URL}/seats/available/${showtimeId}`);
        return response.json();
    }
};

// Tickets API
export const ticketsAPI = {
    getByReservation: async (reservationId) => {
        const response = await fetch(`${API_BASE_URL}/tickets/reservation/${reservationId}`, {
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('token')}`
            }
        });
        return response.json();
    },

    download: async (ticketId) => {
        const response = await fetch(`${API_BASE_URL}/tickets/${ticketId}/download`, {
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('token')}`
            }
        });
        return response.blob();
    }
};

// Payment API
export const paymentAPI = {
    createIntent: async (paymentData) => {
        const response = await fetch(`${API_BASE_URL}/payments/create-intent`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('token')}`
            },
            body: JSON.stringify(paymentData)
        });
        return response.json();
    }
};

// Users API (Admin)
export const usersAPI = {
    getAll: async () => {
        const response = await fetch(`${API_BASE_URL}/users`, {
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('token')}`
            }
        });
        return response.json();
    },

    update: async (userId, userData) => {
        const response = await fetch(`${API_BASE_URL}/users/${userId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('token')}`
            },
            body: JSON.stringify(userData)
        });
        return response.json();
    },

    delete: async (userId) => {
        const response = await fetch(`${API_BASE_URL}/users/${userId}`, {
            method: 'DELETE',
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('token')}`
            }
        });
        return response.json();
    }
}; 