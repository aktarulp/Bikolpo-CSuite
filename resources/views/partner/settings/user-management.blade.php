@extends('layouts.partner-layout')

@section('title', 'User Management')

@section('styles')
<style>
    .user-card {
        transition: all 0.3s ease;
    }
    .user-card:hover {
        transform: translateY(-2px);
    }
    .status-badge {
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0% { opacity: 1; }
        50% { opacity: 0.8; }
        100% { opacity: 1; }
    }
    .stats-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    .stats-card-2 {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }
    .stats-card-3 {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }
    .stats-card-4 {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    }
    .stats-card-5 {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    }
    .search-input:focus {
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }
    .table-hover tbody tr:hover {
        background-color: rgba(99, 102, 241, 0.05);
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
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-4 py-6">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-6">
        <div>
            <h1 class="h3 mb-1 text-gray-900 dark:text-white">User Management</h1>
            <p class="text-gray-600 dark:text-gray-400">Manage users, roles, and permissions</p>
        </div>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-outline-secondary" onclick="exportUsers()">
                <i class="fas fa-download me-2"></i>Export
            </button>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                <i class="fas fa-plus me-2"></i>Add New User
            </button>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-6">
        <div class="col-xl-2 col-lg-4 col-md-6 mb-4">
            <div class="card stats-card text-white border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Total Users</h6>
                            <h3 class="mb-0">{{ $stats['total_users'] }}</h3>
                        </div>
                        <div class="fs-2 opacity-75">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-lg-4 col-md-6 mb-4">
            <div class="card stats-card-2 text-white border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Active</h6>
                            <h3 class="mb-0">{{ $stats['active_users'] }}</h3>
                        </div>
                        <div class="fs-2 opacity-75">
                            <i class="fas fa-user-check"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-lg-4 col-md-6 mb-4">
            <div class="card stats-card-3 text-white border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Inactive</h6>
                            <h3 class="mb-0">{{ $stats['inactive_users'] }}</h3>
                        </div>
                        <div class="fs-2 opacity-75">
                            <i class="fas fa-user-times"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-lg-4 col-md-6 mb-4">
            <div class="card stats-card-4 text-white border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Suspended</h6>
                            <h3 class="mb-0">{{ $stats['suspended_users'] }}</h3>
                        </div>
                        <div class="fs-2 opacity-75">
                            <i class="fas fa-user-slash"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-lg-4 col-md-6 mb-4">
            <div class="card stats-card-5 text-white border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Pending</h6>
                            <h3 class="mb-0">{{ $stats['pending_users'] }}</h3>
                        </div>
                        <div class="fs-2 opacity-75">
                            <i class="fas fa-user-clock"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="text" class="form-control search-input" id="searchInput" placeholder="Search users..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <select class="form-select" id="statusFilter">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>Suspended</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select" id="roleFilter">
                        <option value="">All Roles</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}" {{ request('role') == $role->name ? 'selected' : '' }}>{{ $role->display_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select" id="partnerFilter">
                        <option value="">All Partners</option>
                        @foreach($partners as $partner)
                            <option value="{{ $partner->id }}" {{ request('partner') == $partner->id ? 'selected' : '' }}>{{ $partner->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-outline-secondary w-100" onclick="clearFilters()">
                        <i class="fas fa-times me-2"></i>Clear
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Users</h5>
                <div class="d-flex gap-2">
                    <select class="form-select form-select-sm" id="sortSelect" style="width: auto;">
                        <option value="created_at-desc" {{ request('sort_by', 'created_at') == 'created_at' && request('sort_order', 'desc') == 'desc' ? 'selected' : '' }}>Newest First</option>
                        <option value="created_at-asc" {{ request('sort_by', 'created_at') == 'created_at' && request('sort_order', 'desc') == 'asc' ? 'selected' : '' }}>Oldest First</option>
                        <option value="name-asc" {{ request('sort_by') == 'name' && request('sort_order') == 'asc' ? 'selected' : '' }}>Name A-Z</option>
                        <option value="name-desc" {{ request('sort_by') == 'name' && request('sort_order') == 'desc' ? 'selected' : '' }}>Name Z-A</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4 py-3">
                                <input type="checkbox" class="form-check-input" id="selectAll">
                            </th>
                            <th class="px-4 py-3">User</th>
                            <th class="px-4 py-3">Roles</th>
                            <th class="px-4 py-3">Partner</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Created</th>
                            <th class="px-4 py-3 text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="usersTableBody">
                        @foreach($users as $user)
                            <tr>
                                <td class="px-4 py-3">
                                    <input type="checkbox" class="form-check-input user-checkbox" value="{{ $user->id }}">
                                </td>
                                <td class="px-4 py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar me-3">
                                            @if($user->avatar)
                                                <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="rounded-circle" width="40" height="40">
                                            @else
                                                <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white" width="40" height="40">
                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="fw-semibold">{{ $user->name }}</div>
                                            <div class="text-muted small">{{ $user->email }}</div>
                                            @if($user->phone)
                                                <div class="text-muted small">{{ $user->phone }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    @foreach($user->roles as $role)
                                        <span class="badge bg-secondary me-1">{{ $role->display_name }}</span>
                                    @endforeach
                                </td>
                                <td class="px-4 py-3">
                                    {{ $user->partner?->name ?? 'N/A' }}
                                </td>
                                <td class="px-4 py-3">
                                    @php
                                        $statusClass = match($user->status) {
                                            'active' => 'bg-success',
                                            'inactive' => 'bg-secondary',
                                            'suspended' => 'bg-danger',
                                            'pending' => 'bg-warning',
                                            default => 'bg-secondary'
                                        };
                                        $statusIcon = match($user->status) {
                                            'active' => 'fa-check-circle',
                                            'inactive' => 'fa-minus-circle',
                                            'suspended' => 'fa-times-circle',
                                            'pending' => 'fa-clock',
                                            default => 'fa-question-circle'
                                        };
                                    @endphp
                                    <span class="badge {{ $statusClass }} status-badge">
                                        <i class="fas {{ $statusIcon }} me-1"></i>
                                        {{ ucfirst($user->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="text-muted small">{{ $user->created_at->format('M d, Y') }}</div>
                                    <div class="text-muted smaller">{{ $user->created_at->format('h:i A') }}</div>
                                </td>
                                <td class="px-4 py-3 text-end">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="viewUser({{ $user->id }})">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="editUser({{ $user->id }})">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteUser({{ $user->id }})">
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
        <div class="card-footer bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} users
                </div>
                <div>
                    {{ $users->links('vendor.pagination.bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Bulk Actions -->
    <div class="card mt-4" id="bulkActionsCard" style="display: none;">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted">Selected <span id="selectedCount">0</span> users</span>
                </div>
                <div class="d-flex gap-2">
                    <select class="form-select form-select-sm" id="bulkActionSelect" style="width: auto;">
                        <option value="">Choose Action</option>
                        <option value="activate">Activate</option>
                        <option value="deactivate">Deactivate</option>
                        <option value="suspend">Suspend</option>
                        <option value="delete">Delete</option>
                    </select>
                    <button type="button" class="btn btn-sm btn-primary" onclick="performBulkAction()">
                        Apply
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="clearSelection()">
                        Clear
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addUserForm">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="userName" class="form-label">Full Name *</label>
                            <input type="text" class="form-control" id="userName" name="name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="userEmail" class="form-label">Email Address *</label>
                            <input type="email" class="form-control" id="userEmail" name="email" required>
                        </div>
                        <div class="col-md-6">
                            <label for="userPhone" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" id="userPhone" name="phone">
                        </div>
                        <div class="col-md-6">
                            <label for="userPartner" class="form-label">Partner</label>
                            <select class="form-select" id="userPartner" name="partner_id">
                                <option value="">Select Partner</option>
                                @foreach($partners as $partner)
                                    <option value="{{ $partner->id }}">{{ $partner->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="userPassword" class="form-label">Password *</label>
                            <input type="password" class="form-control" id="userPassword" name="password" required>
                        </div>
                        <div class="col-md-6">
                            <label for="userPasswordConfirm" class="form-label">Confirm Password *</label>
                            <input type="password" class="form-control" id="userPasswordConfirm" name="password_confirmation" required>
                        </div>
                        <div class="col-md-6">
                            <label for="userStatus" class="form-label">Status</label>
                            <select class="form-select" id="userStatus" name="status">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="pending">Pending</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="userRoles" class="form-label">Roles *</label>
                            <select class="form-select" id="userRoles" name="role_ids[]" multiple required>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->display_name }}</option>
                                @endforeach
                            </select>
                            <div class="form-text">Hold Ctrl/Cmd to select multiple roles</div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="addUser()">
                    <i class="fas fa-plus me-2"></i>Add User
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editUserForm">
                    <input type="hidden" id="editUserId" name="user_id">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="editUserName" class="form-label">Full Name *</label>
                            <input type="text" class="form-control" id="editUserName" name="name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="editUserEmail" class="form-label">Email Address *</label>
                            <input type="email" class="form-control" id="editUserEmail" name="email" required>
                        </div>
                        <div class="col-md-6">
                            <label for="editUserPhone" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" id="editUserPhone" name="phone">
                        </div>
                        <div class="col-md-6">
                            <label for="editUserPartner" class="form-label">Partner</label>
                            <select class="form-select" id="editUserPartner" name="partner_id">
                                <option value="">Select Partner</option>
                                @foreach($partners as $partner)
                                    <option value="{{ $partner->id }}">{{ $partner->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="editUserPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id="editUserPassword" name="password">
                            <div class="form-text">Leave blank to keep current password</div>
                        </div>
                        <div class="col-md-6">
                            <label for="editUserPasswordConfirm" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="editUserPasswordConfirm" name="password_confirmation">
                        </div>
                        <div class="col-md-6">
                            <label for="editUserStatus" class="form-label">Status</label>
                            <select class="form-select" id="editUserStatus" name="status">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="suspended">Suspended</option>
                                <option value="pending">Pending</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="editUserRoles" class="form-label">Roles *</label>
                            <select class="form-select" id="editUserRoles" name="role_ids[]" multiple required>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->display_name }}</option>
                                @endforeach
                            </select>
                            <div class="form-text">Hold Ctrl/Cmd to select multiple roles</div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="updateUser()">
                    <i class="fas fa-save me-2"></i>Update User
                </button>
            </div>
        </div>
    </div>
</div>

<!-- View User Modal -->
<div class="modal fade" id="viewUserModal" tabindex="-1" aria-labelledby="viewUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewUserModalLabel">User Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="viewUserContent">
                <!-- Content will be loaded dynamically -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="editUserFromView()">
                    <i class="fas fa-edit me-2"></i>Edit User
                </button>
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
