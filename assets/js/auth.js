import { authAPI } from './api.js';

// Check if user is authenticated
export function isAuthenticated() {
    return !!localStorage.getItem('token');
}

// Check if user is admin
export function isAdmin() {
    return localStorage.getItem('role') === 'admin';
}

// Get current user
export function getCurrentUser() {
    const user = localStorage.getItem('user');
    return user ? JSON.parse(user) : null;
}

// Login user
export async function login(email, password) {
    try {
        const response = await authAPI.login(email, password);
        
        if (response.token) {
            localStorage.setItem('token', response.token);
            localStorage.setItem('role', response.role);
            localStorage.setItem('user', JSON.stringify(response.user));
            return true;
        }
        
        throw new Error(response.message || 'Login failed');
    } catch (error) {
        throw error;
    }
}

// Register user
export async function register(userData) {
    try {
        const response = await authAPI.register(userData);
        
        if (response.message) {
            return true;
        }
        
        throw new Error(response.message || 'Registration failed');
    } catch (error) {
        throw error;
    }
}

// Update profile
export async function updateProfile(userData) {
    try {
        const response = await authAPI.updateProfile(userData);
        
        if (response.user) {
            localStorage.setItem('user', JSON.stringify(response.user));
            return true;
        }
        
        throw new Error(response.message || 'Profile update failed');
    } catch (error) {
        throw error;
    }
}

// Delete account
export async function deleteAccount() {
    try {
        const response = await authAPI.deleteAccount();
        
        if (response.message) {
            logout();
            return true;
        }
        
        throw new Error(response.message || 'Account deletion failed');
    } catch (error) {
        throw error;
    }
}

// Logout user
export function logout() {
    localStorage.removeItem('token');
    localStorage.removeItem('role');
    localStorage.removeItem('user');
    window.location.href = '/login.html';
}

// Require authentication
export function requireAuth() {
    if (!isAuthenticated()) {
        window.location.href = '/login.html';
    }
}

// Require admin role
export function requireAdmin() {
    if (!isAuthenticated() || !isAdmin()) {
        window.location.href = '/login.html';
    }
}

// Get auth headers
export function getAuthHeaders() {
    return {
        'Authorization': `Bearer ${localStorage.getItem('token')}`
    };
} 