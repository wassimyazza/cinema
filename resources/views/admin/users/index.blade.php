@extends('layouts.admin')

@section('title', 'Gestion des utilisateurs - Administration CinéHall')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
        <div class="lg:flex lg:items-center lg:justify-between mb-6">
            <div class="flex-1 min-w-0">
                <h1 class="text-2xl font-semibold text-gray-900">Gestion des utilisateurs</h1>
                <p class="mt-1 text-sm text-gray-500">
                    Gérez les comptes utilisateurs de la plateforme CinéHall
                </p>
            </div>
        </div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
        <!-- Filters -->
        <div class="bg-white shadow rounded-lg mb-6">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex flex-col md:flex-row md:items-end space-y-4 md:space-y-0 md:space-x-4">
                    <div>
                        <label for="role-filter" class="block text-sm font-medium text-gray-700">Rôle</label>
                        <select id="role-filter" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option value="">Tous les rôles</option>
                            <option value="user">Utilisateur</option>
                            <option value="admin">Administrateur</option>
                        </select>
                    </div>
                    
                    <div class="relative flex-1">
                        <label for="search" class="block text-sm font-medium text-gray-700">Rechercher</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text" id="search" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-md" placeholder="Nom, email...">
                        </div>
                    </div>
                    
                    <button id="clear-filters" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <i class="fas fa-times mr-2"></i>
                        Effacer les filtres
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Users Table -->
        <div class="bg-white shadow overflow-hidden rounded-lg">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Utilisateur
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Rôle
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Date d'inscription
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Réservations
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($users as $user)
                            <tr class="user-row" data-role="{{ $user->is_admin ? 'admin' : 'user' }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                            <span class="text-indigo-800 font-medium text-sm">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->is_admin ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                                        {{ $user->is_admin ? 'Administrateur' : 'Utilisateur' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $user->created_at->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $user->reservations_count ?? 0 }} réservations</div>
                                    @if(($user->reservations_count ?? 0) > 0)
                                        <div class="text-xs text-gray-500">
                                            <span class="text-green-600">{{ $user->paid_reservations_count ?? 0 }} payées</span>
                                            @if(($user->reservations_count ?? 0) - ($user->paid_reservations_count ?? 0) > 0)
                                                <span> / </span>
                                                <span class="text-yellow-600">{{ ($user->reservations_count ?? 0) - ($user->paid_reservations_count ?? 0) }} en attente</span>
                                            @endif
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        <button type="button" class="text-indigo-600 hover:text-indigo-900 toggle-role-btn" data-id="{{ $user->id }}" data-is-admin="{{ $user->is_admin ? 'true' : 'false' }}" title="{{ $user->is_admin ? 'Rétrograder' : 'Promouvoir' }}">
                                            <i class="fas {{ $user->is_admin ? 'fa-user' : 'fa-user-shield' }}"></i>
                                        </button>
                                        @if(!$user->is_admin || Auth::id() !== $user->id) {{-- Don't allow deleting yourself as admin --}}
                                            <button type="button" class="text-red-600 hover:text-red-900 delete-user" data-id="{{ $user->id }}" data-name="{{ $user->name }}" title="Supprimer">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        
                        <!-- Empty state when no users match filters -->
                        <tr id="empty-row" class="hidden">
                            <td colspan="5" class="px-6 py-10 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-users text-gray-400 text-3xl mb-3"></i>
                                    <p class="text-gray-500 text-lg font-medium">Aucun utilisateur trouvé</p>
                                    <p class="text-gray-400 mt-1">Essayez de modifier vos filtres</p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($users->hasPages())
                <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div id="delete-modal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <i class="fas fa-exclamation-triangle text-red-600"></i>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Supprimer l'utilisateur
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                Êtes-vous sûr de vouloir supprimer l'utilisateur "<span id="user-name-to-delete"></span>" ? Cette action est irréversible et supprimera également toutes les réservations associées à cet utilisateur.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <form id="delete-form" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Supprimer
                    </button>
                </form>
                <button type="button" id="cancel-delete" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Annuler
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Toggle Role Modal -->
<div id="toggle-role-modal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 sm:mx-0 sm:h-10 sm:w-10">
                        <i class="fas fa-user-shield text-indigo-600"></i>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="toggle-role-title">
                            Changer le rôle de l'utilisateur
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500" id="toggle-role-message">
                                Voulez-vous promouvoir cet utilisateur au rôle d'administrateur ?
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <form id="toggle-role-form" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="is_admin" id="is-admin-input" value="0">
                    <button type="submit" id="toggle-role-btn" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Confirmer
                    </button>
                </form>
                <button type="button" id="cancel-toggle-role" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Annuler
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filter users
    const roleFilter = document.getElementById('role-filter');
    const searchInput = document.getElementById('search');
    const clearFiltersBtn = document.getElementById('clear-filters');
    const userRows = document.querySelectorAll('.user-row');
    const emptyRow = document.getElementById('empty-row');
    
    function filterUsers() {
        const selectedRole = roleFilter.value;
        const searchTerm = searchInput.value.toLowerCase();
        let visibleCount = 0;
        
        userRows.forEach(row => {
            const role = row.dataset.role;
            const userInfo = row.querySelector('.text-sm.font-medium').textContent.toLowerCase() + 
                             row.querySelector('.text-sm.text-gray-500').textContent.toLowerCase();
            
            const matchesRole = selectedRole === '' || role === selectedRole;
            const matchesSearch = searchTerm === '' || userInfo.includes(searchTerm);
            
            if (matchesRole && matchesSearch) {
                row.classList.remove('hidden');
                visibleCount++;
            } else {
                row.classList.add('hidden');
            }
        });
        
        // Show/hide empty state
        if (visibleCount === 0) {
            emptyRow.classList.remove('hidden');
        } else {
            emptyRow.classList.add('hidden');
        }
    }
    
    roleFilter.addEventListener('change', filterUsers);
    searchInput.addEventListener('input', filterUsers);
    
    clearFiltersBtn.addEventListener('click', function() {
        roleFilter.value = '';
        searchInput.value = '';
        filterUsers();
    });
    
    // Handle delete modal
    const deleteModal = document.getElementById('delete-modal');
    const deleteButtons = document.querySelectorAll('.delete-user');
    const cancelDeleteBtn = document.getElementById('cancel-delete');
    const userNameElement = document.getElementById('user-name-to-delete');
    const deleteForm = document.getElementById('delete-form');
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const userId = this.dataset.id;
            const userName = this.dataset.name;
            
            // Update modal content
            userNameElement.textContent = userName;
            deleteForm.action = `/admin/users/${userId}`;
            
            // Show modal
            deleteModal.classList.remove('hidden');
        });
    });
    
    cancelDeleteBtn.addEventListener('click', function() {
        deleteModal.classList.add('hidden');
    });
    
    // Close modal when clicking outside
    deleteModal.addEventListener('click', function(e) {
        if (e.target === deleteModal) {
            deleteModal.classList.add('hidden');
        }
    });
    
    // Handle toggle role modal
    const toggleRoleModal = document.getElementById('toggle-role-modal');
    const toggleRoleButtons = document.querySelectorAll('.toggle-role-btn');
    const cancelToggleRoleBtn = document.getElementById('cancel-toggle-role');
    const toggleRoleTitle = document.getElementById('toggle-role-title');
    const toggleRoleMessage = document.getElementById('toggle-role-message');
    const toggleRoleForm = document.getElementById('toggle-role-form');
    const isAdminInput = document.getElementById('is-admin-input');
    const toggleRoleBtn = document.getElementById('toggle-role-btn');
    
    toggleRoleButtons.forEach(button => {
        button.addEventListener('click', function() {
            const userId = this.dataset.id;
            const isAdmin = this.dataset.isAdmin === 'true';
            
            // Update modal content based on current role
            if (isAdmin) {
                toggleRoleTitle.textContent = 'Rétrograder l'administrateur';
                toggleRoleMessage.textContent = 'Êtes-vous sûr de vouloir rétrograder cet administrateur au rôle d'utilisateur standard ?';
                isAdminInput.value = '0';
                toggleRoleBtn.className = 'w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-yellow-600 text-base font-medium text-white hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 sm:ml-3 sm:w-auto sm:text-sm';
            } else {
                toggleRoleTitle.textContent = 'Promouvoir l'utilisateur';
                toggleRoleMessage.textContent = 'Êtes-vous sûr de vouloir promouvoir cet utilisateur au rôle d'administrateur ?';
                isAdminInput.value = '1';
                toggleRoleBtn.className = 'w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm';
            }
            
            // Update form action
            toggleRoleForm.action = `/admin/users/${userId}/toggle-role`;
            
            // Show modal
            toggleRoleModal.classList.remove('hidden');
        });
    });
    
    cancelToggleRoleBtn.addEventListener('click', function() {
        toggleRoleModal.classList.add('hidden');
    });
    
    // Close modal when clicking outside
    toggleRoleModal.addEventListener('click', function(e) {
        if (e.target === toggleRoleModal) {
            toggleRoleModal.classList.add('hidden');
        }
    });
    
    // Close modals with escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            deleteModal.classList.add('hidden');
            toggleRoleModal.classList.add('hidden');
        }
    });
});
</script>
@endpush