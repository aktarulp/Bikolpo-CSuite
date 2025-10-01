@extends('layouts.partner-layout')

@section('title', 'User Management')

@push('styles')
<style>
    @layer utilities {
        .status-badge {
            animation: pulse 2s infinite;
        }
        
        .modal-backdrop {
            backdrop-filter: blur(5px);
        }
        
        .loading-spinner {
            border: 3px solid #f3f3f3;
            border-top: 3px solid #6366f1;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }
    }
    
    @keyframes pulse {
        0% { opacity: 1; }
        50% { opacity: 0.8; }
        100% { opacity: 1; }
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
@endpush

@section('content')
<div class="px-4 py-6 sm:px-6 lg:px-8">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-1">User Management</h1>
            <p class="text-gray-600 dark:text-gray-400">Manage users, roles, and permissions</p>
        </div>
        <div class="flex gap-2">
            <button type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200" onclick="exportUsers()">
                <i class="fas fa-download mr-2"></i>Export
            </button>
            <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200" data-bs-toggle="modal" data-bs-target="#addUserModal">
                <i class="fas fa-plus mr-2"></i>Add New User
            </button>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-4 mb-6">
        <!-- Total Users Card -->
        <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex justify-between items-center">
                <div>
                    <h6 class="text-sm font-medium opacity-90 mb-1">Total Users</h6>
                    <h3 class="text-2xl font-bold">{{ $stats['total_users'] }}</h3>
                </div>
                <div class="text-3xl opacity-75">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
        
        <!-- Active Users Card -->
        <div class="bg-gradient-to-br from-pink-500 to-red-500 rounded-xl p-6 text-white shadow-lg">
            <div class="flex justify-between items-center">
                <div>
                    <h6 class="text-sm font-medium opacity-90 mb-1">Active</h6>
                    <h3 class="text-2xl font-bold">{{ $stats['active_users'] }}</h3>
                </div>
                <div class="text-3xl opacity-75">
                    <i class="fas fa-user-check"></i>
                </div>
            </div>
        </div>
        <!-- Inactive Users Card -->
        <div class="bg-gradient-to-br from-blue-400 to-cyan-400 rounded-xl p-6 text-white shadow-lg">
            <div class="flex justify-between items-center">
                <div>
                    <h6 class="text-sm font-medium opacity-90 mb-1">Inactive</h6>
                    <h3 class="text-2xl font-bold">{{ $stats['inactive_users'] }}</h3>
                </div>
                <div class="text-3xl opacity-75">
                    <i class="fas fa-user-times"></i>
                </div>
            </div>
        </div>
        
        <!-- Suspended Users Card -->
        <div class="bg-gradient-to-br from-emerald-400 to-teal-400 rounded-xl p-6 text-white shadow-lg">
            <div class="flex justify-between items-center">
                <div>
                    <h6 class="text-sm font-medium opacity-90 mb-1">Suspended</h6>
                    <h3 class="text-2xl font-bold">{{ $stats['suspended_users'] }}</h3>
                </div>
                <div class="text-3xl opacity-75">
                    <i class="fas fa-user-slash"></i>
                </div>
            </div>
        </div>
        
        <!-- Pending Users Card -->
        <div class="bg-gradient-to-br from-pink-400 to-yellow-400 rounded-xl p-6 text-white shadow-lg">
            <div class="flex justify-between items-center">
                <div>
                    <h6 class="text-sm font-medium opacity-90 mb-1">Pending</h6>
                    <h3 class="text-2xl font-bold">{{ $stats['pending_users'] }}</h3>
                </div>
                <div class="text-3xl opacity-75">
                    <i class="fas fa-user-clock"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 mb-6">
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                <div class="lg:col-span-2">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200" id="searchInput" placeholder="Search users..." value="{{ request('search') }}">
                    </div>
                </div>
                <div>
                    <select class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200" id="statusFilter">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>Suspended</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    </select>
                </div>
                <div>
                    <select class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200" id="roleFilter">
                        <option value="">All Roles</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}" {{ request('role') == $role->name ? 'selected' : '' }}>{{ $role->display_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <select class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200" id="partnerFilter">
                        <option value="">All Partners</option>
                        @foreach($partners as $partner)
                            <option value="{{ $partner->id }}" {{ request('partner') == $partner->id ? 'selected' : '' }}>{{ $partner->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mt-4 flex justify-end">
                <button type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200" onclick="clearFilters()">
                    <i class="fas fa-times mr-2"></i>Clear
                </button>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <h5 class="text-lg font-semibold text-gray-900 dark:text-white">Users</h5>
                <div class="flex gap-2">
                    <select class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 text-sm" id="sortSelect">
                        <option value="created_at-desc" {{ request('sort_by', 'created_at') == 'created_at' && request('sort_order', 'desc') == 'desc' ? 'selected' : '' }}>Newest First</option>
                        <option value="created_at-asc" {{ request('sort_by', 'created_at') == 'created_at' && request('sort_order', 'desc') == 'asc' ? 'selected' : '' }}>Oldest First</option>
                        <option value="name-asc" {{ request('sort_by') == 'name' && request('sort_order') == 'asc' ? 'selected' : '' }}>Name A-Z</option>
                        <option value="name-desc" {{ request('sort_by') == 'name' && request('sort_order') == 'desc' ? 'selected' : '' }}>Name Z-A</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left">
                            <input type="checkbox" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" id="selectAll">
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Roles</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Partner</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Created</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody id="usersTableBody" class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($users as $user)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <input type="checkbox" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 user-checkbox" value="{{ $user->id }}">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 mr-3">
                                        @if($user->avatar)
                                            <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="h-10 w-10 rounded-full object-cover">
                                        @else
                                            <div class="h-10 w-10 rounded-full bg-indigo-600 flex items-center justify-center text-white font-semibold">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->name }}</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $user->email }}</div>
                                        @if($user->phone)
                                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $user->phone }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex flex-wrap gap-1">
                                    @foreach($user->roles as $role)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">{{ $role->display_name }}</span>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                {{ $user->partner?->name ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusClass = match($user->status) {
                                        'active' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                        'inactive' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200',
                                        'suspended' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                                        'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                        default => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200'
                                    };
                                    $statusIcon = match($user->status) {
                                        'active' => 'fa-check-circle',
                                        'inactive' => 'fa-minus-circle',
                                        'suspended' => 'fa-times-circle',
                                        'pending' => 'fa-clock',
                                        default => 'fa-question-circle'
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClass }} status-badge">
                                    <i class="fas {{ $statusIcon }} mr-1"></i>
                                    {{ ucfirst($user->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-white">{{ $user->created_at->format('M d, Y') }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $user->created_at->format('h:i A') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <button type="button" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300" onclick="viewUser({{ $user->id }})">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button type="button" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-300" onclick="editUser({{ $user->id }})">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" onclick="deleteUser({{ $user->id }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="text-sm text-gray-700 dark:text-gray-300">
                    Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} users
                </div>
                <div>
                    {{ $users->links('vendor.pagination.bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Bulk Actions -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 mt-6" id="bulkActionsCard" style="display: none;">
        <div class="p-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <span class="text-sm text-gray-700 dark:text-gray-300">Selected <span id="selectedCount" class="font-semibold">0</span> users</span>
                </div>
                <div class="flex flex-col sm:flex-row gap-2">
                    <select class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 text-sm" id="bulkActionSelect">
                        <option value="">Choose Action</option>
                        <option value="activate">Activate</option>
                        <option value="deactivate">Deactivate</option>
                        <option value="suspend">Suspend</option>
                        <option value="delete">Delete</option>
                    </select>
                    <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200" onclick="performBulkAction()">
                        Apply
                    </button>
                    <button type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200" onclick="clearSelection()">
                        Clear
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add User Modal -->
<div class="fixed inset-0 z-50 overflow-y-auto hidden" id="addUserModal" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity modal-backdrop" data-bs-dismiss="modal"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
        <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
            <div class="bg-white dark:bg-gray-800 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white" id="addUserModalLabel">Add New User</h3>
                    <button type="button" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" data-bs-dismiss="modal">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>
            <div class="px-6 py-4">
                <form id="addUserForm">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="userName" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Full Name *</label>
                            <input type="text" class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200" id="userName" name="name" required>
                        </div>
                        <div>
                            <label for="userEmail" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email Address *</label>
                            <input type="email" class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200" id="userEmail" name="email" required>
                        </div>
                        <div>
                            <label for="userPhone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Phone Number</label>
                            <input type="tel" class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200" id="userPhone" name="phone">
                        </div>
                        <div>
                            <label for="userPartner" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Partner</label>
                            <select class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200" id="userPartner" name="partner_id">
                                <option value="">Select Partner</option>
                                @foreach($partners as $partner)
                                    <option value="{{ $partner->id }}">{{ $partner->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="userPassword" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Password *</label>
                            <input type="password" class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200" id="userPassword" name="password" required>
                        </div>
                        <div>
                            <label for="userPasswordConfirm" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Confirm Password *</label>
                            <input type="password" class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200" id="userPasswordConfirm" name="password_confirmation" required>
                        </div>
                        <div>
                            <label for="userStatus" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                            <select class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200" id="userStatus" name="status">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="pending">Pending</option>
                            </select>
                        </div>
                        <div>
                            <label for="userRoles" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Roles *</label>
                            <select class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200" id="userRoles" name="role_ids[]" multiple required>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->display_name }}</option>
                                @endforeach
                            <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">Hold Ctrl/Cmd to select multiple roles</div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700 px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                <div class="flex justify-end space-x-3">
                    <button type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200" onclick="addUser()">
                        <i class="fas fa-plus mr-2"></i>Add User
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit User Modal -->
<div class="fixed inset-0 z-50 overflow-y-auto hidden" id="editUserModal" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity modal-backdrop" data-bs-dismiss="modal"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
        <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
            <div class="bg-white dark:bg-gray-800 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white" id="editUserModalLabel">Edit User</h3>
                    <button type="button" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" data-bs-dismiss="modal">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>
            <div class="px-6 py-4">
                <form id="editUserForm">
                    <input type="hidden" id="editUserId" name="user_id">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="editUserName" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Full Name *</label>
                            <input type="text" class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200" id="editUserName" name="name" required>
                        </div>
                        <div>
                            <label for="editUserEmail" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email Address *</label>
                            <input type="email" class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200" id="editUserEmail" name="email" required>
                        </div>
                        <div>
                            <label for="editUserPhone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Phone Number</label>
                            <input type="tel" class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200" id="editUserPhone" name="phone">
                        </div>
                        <div>
                            <label for="editUserPartner" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Partner</label>
                            <select class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200" id="editUserPartner" name="partner_id">
                                <option value="">Select Partner</option>
                                @foreach($partners as $partner)
                                    <option value="{{ $partner->id }}">{{ $partner->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="editUserPassword" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Password</label>
                            <input type="password" class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200" id="editUserPassword" name="password">
                            <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">Leave blank to keep current password</div>
                        </div>
                        <div>
                            <label for="editUserPasswordConfirm" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Confirm Password</label>
                            <input type="password" class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200" id="editUserPasswordConfirm" name="password_confirmation">
                        </div>
                        <div>
                            <label for="editUserStatus" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                            <select class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200" id="editUserStatus" name="status">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="suspended">Suspended</option>
                                <option value="pending">Pending</option>
                            </select>
                        </div>
                        <div>
                            <label for="editUserRoles" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Roles *</label>
                            <select class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200" id="editUserRoles" name="role_ids[]" multiple required>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->display_name }}</option>
                                @endforeach
                            </select>
                            <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">Hold Ctrl/Cmd to select multiple roles</div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700 px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                <div class="flex justify-end space-x-3">
                    <button type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200" onclick="updateUser()">
                        <i class="fas fa-save mr-2"></i>Update User
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- View User Modal -->
<div class="fixed inset-0 z-50 overflow-y-auto hidden" id="viewUserModal" aria-labelledby="viewUserModalLabel" aria-hidden="true">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity modal-backdrop" data-bs-dismiss="modal"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
        <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-6xl sm:w-full">
            <div class="bg-white dark:bg-gray-800 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white" id="viewUserModalLabel">User Details</h3>
                    <button type="button" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" data-bs-dismiss="modal">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>
            <div class="px-6 py-4" id="viewUserContent">
                <!-- Content will be loaded dynamically -->
            </div>
            <div class="bg-gray-50 dark:bg-gray-700 px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                <div class="flex justify-end space-x-3">
                    <button type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200" onclick="editUserFromView()">
                        <i class="fas fa-edit mr-2"></i>Edit User
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
let currentUserId = null;

// Initialize tooltips
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
});

// Search functionality
document.getElementById('searchInput').addEventListener('input', function(e) {
    applyFilters();
});

document.getElementById('statusFilter').addEventListener('change', function(e) {
    applyFilters();
});

document.getElementById('roleFilter').addEventListener('change', function(e) {
    applyFilters();
});

document.getElementById('partnerFilter').addEventListener('change', function(e) {
    applyFilters();
});

document.getElementById('sortSelect').addEventListener('change', function(e) {
    applyFilters();
});

function applyFilters() {
    const search = document.getElementById('searchInput').value;
    const status = document.getElementById('statusFilter').value;
    const role = document.getElementById('roleFilter').value;
    const partner = document.getElementById('partnerFilter').value;
    const sort = document.getElementById('sortSelect').value;
    
    const [sortBy, sortOrder] = sort.split('-');
    
    const params = new URLSearchParams();
    if (search) params.append('search', search);
    if (status) params.append('status', status);
    if (role) params.append('role', role);
    if (partner) params.append('partner', partner);
    if (sortBy) params.append('sort_by', sortBy);
    if (sortOrder) params.append('sort_order', sortOrder);
    
    window.location.href = '{{ route("partner.settings.user-management") }}?' + params.toString();
}

function clearFilters() {
    document.getElementById('searchInput').value = '';
    document.getElementById('statusFilter').value = '';
    document.getElementById('roleFilter').value = '';
    document.getElementById('partnerFilter').value = '';
    document.getElementById('sortSelect').value = 'created_at-desc';
    applyFilters();
}

// Checkbox functionality
document.getElementById('selectAll').addEventListener('change', function(e) {
    const checkboxes = document.querySelectorAll('.user-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = e.target.checked;
    });
    updateBulkActions();
});

document.addEventListener('change', function(e) {
    if (e.target.classList.contains('user-checkbox')) {
        updateBulkActions();
    }
});

function updateBulkActions() {
    const selectedCheckboxes = document.querySelectorAll('.user-checkbox:checked');
    const selectedCount = selectedCheckboxes.length;
    const bulkActionsCard = document.getElementById('bulkActionsCard');
    const selectedCountSpan = document.getElementById('selectedCount');
    
    selectedCountSpan.textContent = selectedCount;
    
    if (selectedCount > 0) {
        bulkActionsCard.style.display = 'block';
    } else {
        bulkActionsCard.style.display = 'none';
    }
}

function clearSelection() {
    document.querySelectorAll('.user-checkbox').forEach(checkbox => {
        checkbox.checked = false;
    });
    document.getElementById('selectAll').checked = false;
    updateBulkActions();
}

function performBulkAction() {
    const action = document.getElementById('bulkActionSelect').value;
    if (!action) {
        alert('Please select an action');
        return;
    }
    
    const selectedCheckboxes = document.querySelectorAll('.user-checkbox:checked');
    const userIds = Array.from(selectedCheckboxes).map(cb => cb.value);
    
    if (confirm(`Are you sure you want to ${action} ${userIds.length} users?`)) {
        // Implement bulk action logic here
        console.log('Bulk action:', action, 'User IDs:', userIds);
    }
}

// User management functions
function addUser() {
    const form = document.getElementById('addUserForm');
    const formData = new FormData(form);
    
    fetch('{{ route("partner.settings.users.store") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(Object.fromEntries(formData))
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('User created successfully');
            bootstrap.Modal.getInstance(document.getElementById('addUserModal')).hide();
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while creating the user');
    });
}

function editUser(userId) {
    currentUserId = userId;
    
    fetch(`/api/users/${userId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const user = data.user;
                document.getElementById('editUserId').value = user.id;
                document.getElementById('editUserName').value = user.name;
                document.getElementById('editUserEmail').value = user.email;
                document.getElementById('editUserPhone').value = user.phone || '';
                document.getElementById('editUserPartner').value = user.partner_id || '';
                document.getElementById('editUserStatus').value = user.status;
                
                // Set roles
                const roleSelect = document.getElementById('editUserRoles');
                Array.from(roleSelect.options).forEach(option => {
                    option.selected = user.roles.some(role => role.id == option.value);
                });
                
                new bootstrap.Modal(document.getElementById('editUserModal')).show();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while loading user data');
        });
}

function updateUser() {
    const form = document.getElementById('editUserForm');
    const formData = new FormData(form);
    
    fetch(`/api/users/${currentUserId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(Object.fromEntries(formData))
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('User updated successfully');
            bootstrap.Modal.getInstance(document.getElementById('editUserModal')).hide();
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while updating the user');
    });
}

function viewUser(userId) {
    fetch(`/api/users/${userId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const user = data.user;
                const content = `
                    <div class="row">
                        <div class="col-md-4">
                            <div class="text-center mb-4">
                                ${user.avatar ? 
                                    `<img src="${user.avatar}" alt="${user.name}" class="rounded-circle mb-3" width="120" height="120">` :
                                    `<div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white mx-auto mb-3" style="width: 120px; height: 120px; font-size: 48px;">
                                        ${user.name.charAt(0).toUpperCase()}
                                    </div>`
                                }
                                <h5>${user.name}</h5>
                                <p class="text-muted">${user.email}</p>
                                ${user.phone ? `<p class="text-muted">${user.phone}</p>` : ''}
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <strong>Status:</strong>
                                    <span class="badge bg-${user.status === 'active' ? 'success' : user.status === 'inactive' ? 'secondary' : user.status === 'suspended' ? 'danger' : 'warning'} ms-2">
                                        ${user.status.charAt(0).toUpperCase() + user.status.slice(1)}
                                    </span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>Partner:</strong> ${user.partner?.name || 'N/A'}
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>Created:</strong> ${new Date(user.created_at).toLocaleDateString()}
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>Last Updated:</strong> ${new Date(user.updated_at).toLocaleDateString()}
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <strong>Roles:</strong>
                                <div class="mt-2">
                                    ${user.roles.map(role => `<span class="badge bg-secondary me-1">${role.display_name}</span>`).join('')}
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <strong>Permissions:</strong>
                                <div class="mt-2">
                                    ${user.permissions.map(permission => `<span class="badge bg-info me-1">${permission.display_name}</span>`).join('')}
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                
                document.getElementById('viewUserContent').innerHTML = content;
                new bootstrap.Modal(document.getElementById('viewUserModal')).show();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while loading user data');
        });
}

function deleteUser(userId) {
    if (confirm('Are you sure you want to delete this user? This action cannot be undone.')) {
        fetch(`/api/users/${userId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('User deleted successfully');
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while deleting the user');
        });
    }
}

function editUserFromView() {
    bootstrap.Modal.getInstance(document.getElementById('viewUserModal')).hide();
    editUser(currentUserId);
}

function exportUsers() {
    window.location.href = '{{ route("partner.settings.users.export") }}';
}

// Initialize page
document.addEventListener('DOMContentLoaded', function() {
    updateBulkActions();
});
</script>
@endsection
