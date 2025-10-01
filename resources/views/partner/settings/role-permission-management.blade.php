@extends('layouts.partner-layout')

@section('title', 'Role & Permission Management')

@section('styles')
<style>
    .role-card {
        transition: all 0.3s ease;
        border-left: 4px solid transparent;
    }
    .role-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    .role-card.super-admin {
        border-left-color: #8b5cf6;
    }
    .role-card.admin {
        border-left-color: #ef4444;
    }
    .role-card.manager {
        border-left-color: #f97316;
    }
    .role-card.supervisor {
        border-left-color: #eab308;
    }
    .role-card.staff {
        border-left-color: #22c55e;
    }
    .role-card.user {
        border-left-color: #3b82f6;
    }
    .permission-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1rem;
    }
    .permission-module {
        background: #f8fafc;
        border-radius: 0.5rem;
        padding: 1rem;
        border: 1px solid #e2e8f0;
    }
    .permission-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.5rem;
        border-radius: 0.375rem;
        transition: background-color 0.2s;
    }
    .permission-item:hover {
        background-color: #f1f5f9;
    }
    .hierarchy-tree {
        font-family: monospace;
        font-size: 0.875rem;
        line-height: 1.5;
    }
    .tree-node {
        padding-left: 1rem;
        position: relative;
    }
    .tree-node::before {
        content: '├── ';
        color: #94a3b8;
        position: absolute;
        left: 0;
    }
    .tree-node:last-child::before {
        content: '└── ';
    }
    .modal-backdrop {
        backdrop-filter: blur(5px);
    }
    .permission-checkbox {
        width: 1.25rem;
        height: 1.25rem;
        cursor: pointer;
    }
    .role-permission-grid {
        overflow-x: auto;
    }
    .role-permission-grid table {
        min-width: 800px;
    }
    .role-permission-grid th,
    .role-permission-grid td {
        text-align: center;
        vertical-align: middle;
        padding: 0.5rem;
        font-size: 0.875rem;
    }
    .role-permission-grid th {
        background-color: #f8fafc;
        font-weight: 600;
        position: sticky;
        top: 0;
        z-index: 10;
    }
    .role-permission-grid .module-header {
        background-color: #e2e8f0;
        font-weight: 600;
        text-align: left;
    }
    .permission-cell {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
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
</style>
@endsection

@section('content')
<div class="container-fluid px-4 py-6">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-6">
        <div>
            <h1 class="h3 mb-1 text-gray-900 dark:text-white">Role & Permission Management</h1>
            <p class="text-gray-600 dark:text-gray-400">Manage roles, permissions, and access control</p>
        </div>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-outline-secondary" onclick="exportRoles()">
                <i class="fas fa-download me-2"></i>Export
            </button>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRoleModal">
                <i class="fas fa-plus me-2"></i>Add Role
            </button>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-6">
        <div class="col-xl-3 col-lg-6 mb-4">
            <div class="card stats-card text-white border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Total Roles</h6>
                            <h3 class="mb-0">{{ $roles->count() }}</h3>
                        </div>
                        <div class="fs-2 opacity-75">
                            <i class="fas fa-user-tag"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 mb-4">
            <div class="card stats-card-2 text-white border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Active Roles</h6>
                            <h3 class="mb-0">{{ $roles->where('status', 'active')->count() }}</h3>
                        </div>
                        <div class="fs-2 opacity-75">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 mb-4">
            <div class="card stats-card-3 text-white border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Total Permissions</h6>
                            <h3 class="mb-0">{{ $permissions->count() }}</h3>
                        </div>
                        <div class="fs-2 opacity-75">
                            <i class="fas fa-key"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 mb-4">
            <div class="card stats-card-4 text-white border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Permission Modules</h6>
                            <h3 class="mb-0">{{ $permissions->pluck('module')->unique()->count() }}</h3>
                        </div>
                        <div class="fs-2 opacity-75">
                            <i class="fas fa-cube"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs Navigation -->
    <ul class="nav nav-tabs mb-4" id="rolePermissionTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="roles-tab" data-bs-toggle="tab" data-bs-target="#roles" type="button" role="tab" aria-controls="roles" aria-selected="true">
                <i class="fas fa-user-tag me-2"></i>Roles
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="permissions-tab" data-bs-toggle="tab" data-bs-target="#permissions" type="button" role="tab" aria-controls="permissions" aria-selected="false">
                <i class="fas fa-key me-2"></i>Permissions
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="grid-tab" data-bs-toggle="tab" data-bs-target="#grid" type="button" role="tab" aria-controls="grid" aria-selected="false">
                <i class="fas fa-th me-2"></i>Permission Grid
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="hierarchy-tab" data-bs-toggle="tab" data-bs-target="#hierarchy" type="button" role="tab" aria-controls="hierarchy" aria-selected="false">
                <i class="fas fa-sitemap me-2"></i>Hierarchy
            </button>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content" id="rolePermissionTabsContent">
        <!-- Roles Tab -->
        <div class="tab-pane fade show active" id="roles" role="tabpanel" aria-labelledby="roles-tab">
            <div class="card">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Roles</h5>
                        <div class="d-flex gap-2">
                            <input type="text" class="form-control form-control-sm" id="roleSearch" placeholder="Search roles..." style="width: 200px;">
                            <select class="form-select form-select-sm" id="roleLevelFilter" style="width: auto;">
                                <option value="">All Levels</option>
                                <option value="1">Super Admin</option>
                                <option value="2">Admin</option>
                                <option value="3">Manager</option>
                                <option value="4">Supervisor</option>
                                <option value="5">Staff</option>
                                <option value="6">User</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row" id="rolesContainer">
                        @foreach($roles as $role)
                            <div class="col-lg-4 col-md-6 mb-4 role-item" data-role-name="{{ $role->name }}" data-role-level="{{ $role->level }}">
                                <div class="card role-card {{ $role->name }} h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <div>
                                                <h6 class="card-title mb-1">{{ $role->display_name }}</h6>
                                                <p class="text-muted small mb-2">{{ $role->description }}</p>
                                                <div class="d-flex gap-2 mb-2">
                                                    {!! $role->level_badge !!}
                                                    {!! $role->status_badge !!}
                                                    @if($role->inherit_permissions)
                                                        {!! $role->inheritance_mode_badge !!}
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="dropdown">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="#" onclick="editRole({{ $role->id }})">
                                                        <i class="fas fa-edit me-2"></i>Edit
                                                    </a></li>
                                                    <li><a class="dropdown-item" href="#" onclick="viewRole({{ $role->id }})">
                                                        <i class="fas fa-eye me-2"></i>View Details
                                                    </a></li>
                                                    <li><a class="dropdown-item" href="#" onclick="cloneRole({{ $role->id }})">
                                                        <i class="fas fa-copy me-2"></i>Clone
                                                    </a></li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li><a class="dropdown-item text-danger" href="#" onclick="deleteRole({{ $role->id }})">
                                                        <i class="fas fa-trash me-2"></i>Delete
                                                    </a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <small class="text-muted">Permissions</small>
                                                <small class="text-muted">{{ $role->permissions->count() }}</small>
                                            </div>
                                            <div class="progress" style="height: 4px;">
                                                <div class="progress-bar" role="progressbar" style="width: {{ min($role->permissions->count() * 10, 100) }}%"></div>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <small class="text-muted">Users</small>
                                                <small class="text-muted">{{ $role->users->count() }}</small>
                                            </div>
                                            <div class="progress" style="height: 4px;">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: {{ min($role->users->count() * 20, 100) }}%"></div>
                                            </div>
                                        </div>
                                        
                                        @if($role->parentRole)
                                            <div class="mb-2">
                                                <small class="text-muted">Parent Role:</small>
                                                <span class="badge bg-secondary">{{ $role->parentRole->display_name }}</span>
                                            </div>
                                        @endif
                                        
                                        @if($role->childRoles->count() > 0)
                                            <div class="mb-2">
                                                <small class="text-muted">Child Roles:</small>
                                                <div>
                                                    @foreach($role->childRoles->take(3) as $childRole)
                                                        <span class="badge bg-info me-1">{{ $childRole->display_name }}</span>
                                                    @endforeach
                                                    @if($role->childRoles->count() > 3)
                                                        <span class="badge bg-light text-dark">+{{ $role->childRoles->count() - 3 }} more</span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Permissions Tab -->
        <div class="tab-pane fade" id="permissions" role="tabpanel" aria-labelledby="permissions-tab">
            <div class="card">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Permissions</h5>
                        <div class="d-flex gap-2">
                            <input type="text" class="form-control form-control-sm" id="permissionSearch" placeholder="Search permissions..." style="width: 200px;">
                            <select class="form-select form-select-sm" id="moduleFilter" style="width: auto;">
                                <option value="">All Modules</option>
                                @foreach($permissions->pluck('module')->unique()->sort() as $module)
                                    <option value="{{ $module }}">{{ $module }}</option>
                                @endforeach
                            </select>
                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addPermissionModal">
                                <i class="fas fa-plus me-2"></i>Add Permission
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="permission-grid" id="permissionsContainer">
                        @foreach($permissions->groupBy('module') as $module => $modulePermissions)
                            <div class="permission-module" data-module="{{ $module }}">
                                <h6 class="mb-3">
                                    <i class="fas fa-cube me-2"></i>{{ $module }}
                                    <span class="badge bg-secondary">{{ $modulePermissions->count() }}</span>
                                </h6>
                                <div class="permission-list">
                                    @foreach($modulePermissions as $permission)
                                        <div class="permission-item" data-permission-name="{{ $permission->name }}">
                                            <div>
                                                <div class="fw-semibold">{{ $permission->display_name }}</div>
                                                <div class="text-muted small">{{ $permission->description }}</div>
                                            </div>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="dropdown">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="#" onclick="editPermission({{ $permission->id }})">
                                                        <i class="fas fa-edit me-2"></i>Edit
                                                    </a></li>
                                                    <li><a class="dropdown-item" href="#" onclick="viewPermission({{ $permission->id }})">
                                                        <i class="fas fa-eye me-2"></i>View Details
                                                    </a></li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li><a class="dropdown-item text-danger" href="#" onclick="deletePermission({{ $permission->id }})">
                                                        <i class="fas fa-trash me-2"></i>Delete
                                                    </a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Permission Grid Tab -->
        <div class="tab-pane fade" id="grid" role="tabpanel" aria-labelledby="grid-tab">
            <div class="card">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Role-Permission Matrix</h5>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="expandAll()">
                                <i class="fas fa-expand-arrows-alt me-2"></i>Expand All
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="collapseAll()">
                                <i class="fas fa-compress-arrows-alt me-2"></i>Collapse All
                            </button>
                            <button type="button" class="btn btn-sm btn-primary" onclick="saveGridChanges()">
                                <i class="fas fa-save me-2"></i>Save Changes
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="role-permission-grid">
                        <table class="table table-bordered table-hover mb-0" id="permissionGridTable">
                            <thead>
                                <tr>
                                    <th style="width: 200px; position: sticky; left: 0; background: white; z-index: 15;">Module / Permission</th>
                                    @foreach($roles as $role)
                                        <th style="min-width: 100px;">
                                            <div class="text-center">
                                                <div class="fw-semibold">{{ $role->display_name }}</div>
                                                <div class="small text-muted">{{ $role->users->count() }} users</div>
                                            </div>
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody id="permissionGridBody">
                                <!-- Grid content will be populated by JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hierarchy Tab -->
        <div class="tab-pane fade" id="hierarchy" role="tabpanel" aria-labelledby="hierarchy-tab">
            <div class="card">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Role Hierarchy</h5>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="refreshHierarchy()">
                                <i class="fas fa-sync me-2"></i>Refresh
                            </button>
                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#hierarchySettingsModal">
                                <i class="fas fa-cog me-2"></i>Settings
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title mb-3">Role Hierarchy Tree</h6>
                                    <div class="hierarchy-tree" id="hierarchyTree">
                                        <!-- Hierarchy tree will be populated by JavaScript -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title mb-3">Hierarchy Statistics</h6>
                                    <div id="hierarchyStats">
                                        <!-- Stats will be populated by JavaScript -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Role Modal -->
<div class="modal fade" id="addRoleModal" tabindex="-1" aria-labelledby="addRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addRoleModalLabel">Add New Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addRoleForm">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="roleName" class="form-label">Role Name *</label>
                            <input type="text" class="form-control" id="roleName" name="name" required>
                            <div class="form-text">Unique identifier for the role (e.g., admin, manager)</div>
                        </div>
                        <div class="col-md-6">
                            <label for="roleDisplayName" class="form-label">Display Name *</label>
                            <input type="text" class="form-control" id="roleDisplayName" name="display_name" required>
                            <div class="form-text">Human-readable name (e.g., Administrator, Manager)</div>
                        </div>
                        <div class="col-12">
                            <label for="roleDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="roleDescription" name="description" rows="3"></textarea>
                        </div>
                        <div class="col-md-4">
                            <label for="roleLevel" class="form-label">Level *</label>
                            <select class="form-select" id="roleLevel" name="level" required>
                                <option value="1">1 - Super Admin</option>
                                <option value="2">2 - Admin</option>
                                <option value="3">3 - Manager</option>
                                <option value="4">4 - Supervisor</option>
                                <option value="5">5 - Staff</option>
                                <option value="6">6 - User</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="roleStatus" class="form-label">Status</label>
                            <select class="form-select" id="roleStatus" name="status">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="roleParent" class="form-label">Parent Role</label>
                            <select class="form-select" id="roleParent" name="parent_role_id">
                                <option value="">None</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->display_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="inheritPermissions" class="form-label">Inherit Permissions</label>
                            <select class="form-select" id="inheritPermissions" name="inherit_permissions">
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="inheritanceMode" class="form-label">Inheritance Mode</label>
                            <select class="form-select" id="inheritanceMode" name="permissions_inheritance_mode">
                                <option value="none">None</option>
                                <option value="direct">Direct Parent Only</option>
                                <option value="recursive">Recursive (All Parents)</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="rolePermissions" class="form-label">Permissions</label>
                            <select class="form-select" id="rolePermissions" name="permission_ids[]" multiple size="8">
                                @foreach($permissions->groupBy('module') as $module => $modulePermissions)
                                    <optgroup label="{{ $module }}">
                                        @foreach($modulePermissions as $permission)
                                            <option value="{{ $permission->id }}">{{ $permission->display_name }}</option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                            <div class="form-text">Hold Ctrl/Cmd to select multiple permissions</div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="addRole()">
                    <i class="fas fa-plus me-2"></i>Add Role
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Add Permission Modal -->
<div class="modal fade" id="addPermissionModal" tabindex="-1" aria-labelledby="addPermissionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPermissionModalLabel">Add New Permission</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addPermissionForm">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="permissionName" class="form-label">Permission Name *</label>
                            <input type="text" class="form-control" id="permissionName" name="name" required>
                            <div class="form-text">Unique identifier (e.g., users.create, posts.edit)</div>
                        </div>
                        <div class="col-md-6">
                            <label for="permissionDisplayName" class="form-label">Display Name *</label>
                            <input type="text" class="form-control" id="permissionDisplayName" name="display_name" required>
                            <div class="form-text">Human-readable name (e.g., Create Users, Edit Posts)</div>
                        </div>
                        <div class="col-md-6">
                            <label for="permissionModule" class="form-label">Module *</label>
                            <input type="text" class="form-control" id="permissionModule" name="module" required>
                            <div class="form-text">Module/category (e.g., users, posts, settings)</div>
                        </div>
                        <div class="col-md-6">
                            <label for="permissionStatus" class="form-label">Status</label>
                            <select class="form-select" id="permissionStatus" name="status">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="permissionDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="permissionDescription" name="description" rows="3"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="addPermission()">
                    <i class="fas fa-plus me-2"></i>Add Permission
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Role Modal -->
<div class="modal fade" id="editRoleModal" tabindex="-1" aria-labelledby="editRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editRoleModalLabel">Edit Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editRoleForm">
                    <input type="hidden" id="editRoleId" name="role_id">
                    <!-- Form fields similar to add role modal -->
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="updateRole()">
                    <i class="fas fa-save me-2"></i>Update Role
                </button>
            </div>
        </div>
    </div>
</div>

<!-- View Role Modal -->
<div class="modal fade" id="viewRoleModal" tabindex="-1" aria-labelledby="viewRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewRoleModalLabel">Role Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="viewRoleContent">
                <!-- Content will be loaded dynamically -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="editRoleFromView()">
                    <i class="fas fa-edit me-2"></i>Edit Role
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
let currentRoleId = null;
let currentPermissionId = null;
let permissionGridData = {};

// Initialize page
document.addEventListener('DOMContentLoaded', function() {
    initializePermissionGrid();
    initializeHierarchy();
    setupSearchFilters();
    startRealTimeUpdates();
});

// Real-time updates functionality
let realTimeInterval;
let lastUpdateTime = Math.floor(Date.now() / 1000);

function startRealTimeUpdates() {
    // Check for updates every 30 seconds
    realTimeInterval = setInterval(checkForUpdates, 30000);
}

function checkForUpdates() {
    fetch('/partner/settings/real-time-updates?last_update=' + lastUpdateTime)
        .then(response => response.json())
        .then(data => {
            if (data.success && data.updates.length > 0) {
                processRealTimeUpdates(data.updates);
                lastUpdateTime = Math.floor(Date.now() / 1000);
            }
        })
        .catch(error => {
            console.error('Error checking for real-time updates:', error);
        });
}

function processRealTimeUpdates(updates) {
    updates.forEach(update => {
        switch (update.type) {
            case 'role_permissions':
                showToast(`Role permissions updated for ${update.role_name}`, 'info');
                // Optionally refresh the grid
                if (confirm('Permission changes detected. Refresh the grid?')) {
                    initializePermissionGrid();
                }
                break;
            case 'role_updated':
                showToast(`Role ${update.role_name} was ${update.action}`, 'info');
                break;
        }
    });
}

function broadcastPermissionUpdate() {
    // This would typically use WebSockets or Pusher for real-time broadcasting
    // For now, we'll just show a notification
    showToast('Permission changes broadcasted to all users', 'success');
}

function showToast(message, type = 'info') {
    // Create toast container if it doesn't exist
    let toastContainer = document.getElementById('toastContainer');
    if (!toastContainer) {
        toastContainer = document.createElement('div');
        toastContainer.id = 'toastContainer';
        toastContainer.className = 'toast-container position-fixed top-0 end-0 p-3';
        toastContainer.style.zIndex = '9999';
        document.body.appendChild(toastContainer);
    }
    
    const toastId = 'toast-' + Date.now();
    const bgClass = type === 'success' ? 'bg-success' : type === 'error' ? 'bg-danger' : 'bg-info';
    
    const toastHTML = `
        <div id="${toastId}" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header ${bgClass} text-white">
                <strong class="me-auto">Permission Update</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                ${message}
            </div>
        </div>
    `;
    
    toastContainer.insertAdjacentHTML('beforeend', toastHTML);
    
    const toastElement = document.getElementById(toastId);
    const toast = new bootstrap.Toast(toastElement, {
        autohide: true,
        delay: 5000
    });
    
    toast.show();
    
    // Remove toast element after it's hidden
    toastElement.addEventListener('hidden.bs.toast', function () {
        toastElement.remove();
    });
}

// Search and filter functionality
function setupSearchFilters() {
    document.getElementById('roleSearch').addEventListener('input', function(e) {
        filterRoles();
    });
    
    document.getElementById('roleLevelFilter').addEventListener('change', function(e) {
        filterRoles();
    });
    
    document.getElementById('permissionSearch').addEventListener('input', function(e) {
        filterPermissions();
    });
    
    document.getElementById('moduleFilter').addEventListener('change', function(e) {
        filterPermissions();
    });
}

function filterRoles() {
    const searchTerm = document.getElementById('roleSearch').value.toLowerCase();
    const levelFilter = document.getElementById('roleLevelFilter').value;
    
    document.querySelectorAll('.role-item').forEach(item => {
        const roleName = item.dataset.roleName.toLowerCase();
        const roleLevel = item.dataset.roleLevel;
        
        const matchesSearch = roleName.includes(searchTerm);
        const matchesLevel = !levelFilter || roleLevel === levelFilter;
        
        item.style.display = matchesSearch && matchesLevel ? 'block' : 'none';
    });
}

function filterPermissions() {
    const searchTerm = document.getElementById('permissionSearch').value.toLowerCase();
    const moduleFilter = document.getElementById('moduleFilter').value;
    
    document.querySelectorAll('.permission-module').forEach(module => {
        const moduleName = module.dataset.module;
        const permissions = module.querySelectorAll('.permission-item');
        let hasVisiblePermissions = false;
        
        permissions.forEach(permission => {
            const permissionName = permission.dataset.permissionName.toLowerCase();
            
            const matchesSearch = permissionName.includes(searchTerm);
            const matchesModule = !moduleFilter || moduleName === moduleFilter;
            
            if (matchesSearch && matchesModule) {
                permission.style.display = 'flex';
                hasVisiblePermissions = true;
            } else {
                permission.style.display = 'none';
            }
        });
        
        module.style.display = hasVisiblePermissions ? 'block' : 'none';
    });
}

// Role management functions
function addRole() {
    const form = document.getElementById('addRoleForm');
    const formData = new FormData(form);
    
    fetch('/api/roles', {
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
            alert('Role created successfully');
            bootstrap.Modal.getInstance(document.getElementById('addRoleModal')).hide();
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while creating the role');
    });
}

function editRole(roleId) {
    currentRoleId = roleId;
    // Load role data and populate edit form
    fetch(`/api/roles/${roleId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const role = data.role;
                // Populate form fields
                document.getElementById('editRoleId').value = role.id;
                // ... populate other fields
                new bootstrap.Modal(document.getElementById('editRoleModal')).show();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while loading role data');
        });
}

function updateRole() {
    const form = document.getElementById('editRoleForm');
    const formData = new FormData(form);
    
    fetch(`/api/roles/${currentRoleId}`, {
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
            alert('Role updated successfully');
            bootstrap.Modal.getInstance(document.getElementById('editRoleModal')).hide();
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while updating the role');
    });
}

function viewRole(roleId) {
    fetch(`/api/roles/${roleId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const role = data.role;
                const content = `
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Basic Information</h6>
                            <table class="table table-sm">
                                <tr><td><strong>Name:</strong></td><td>${role.name}</td></tr>
                                <tr><td><strong>Display Name:</strong></td><td>${role.display_name}</td></tr>
                                <tr><td><strong>Description:</strong></td><td>${role.description || 'N/A'}</td></tr>
                                <tr><td><strong>Level:</strong></td><td>${role.level}</td></tr>
                                <tr><td><strong>Status:</strong></td><td>${role.status}</td></tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6>Relationships</h6>
                            <table class="table table-sm">
                                <tr><td><strong>Parent Role:</strong></td><td>${role.parent_role?.display_name || 'None'}</td></tr>
                                <tr><td><strong>Child Roles:</strong></td><td>${role.child_roles?.length || 0}</td></tr>
                                <tr><td><strong>Users:</strong></td><td>${role.users?.length || 0}</td></tr>
                                <tr><td><strong>Permissions:</strong></td><td>${role.permissions?.length || 0}</td></tr>
                            </table>
                        </div>
                    </div>
                `;
                document.getElementById('viewRoleContent').innerHTML = content;
                new bootstrap.Modal(document.getElementById('viewRoleModal')).show();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while loading role data');
        });
}

function deleteRole(roleId) {
    if (confirm('Are you sure you want to delete this role? This action cannot be undone.')) {
        fetch(`/api/roles/${roleId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Role deleted successfully');
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while deleting the role');
        });
    }
}

function cloneRole(roleId) {
    if (confirm('Are you sure you want to clone this role?')) {
        fetch(`/api/roles/${roleId}/clone`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Role cloned successfully');
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while cloning the role');
        });
    }
}

// Permission management functions
function addPermission() {
    const form = document.getElementById('addPermissionForm');
    const formData = new FormData(form);
    
    fetch('/api/permissions', {
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
            alert('Permission created successfully');
            bootstrap.Modal.getInstance(document.getElementById('addPermissionModal')).hide();
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while creating the permission');
    });
}

function editPermission(permissionId) {
    currentPermissionId = permissionId;
    // Load permission data and populate edit form
    fetch(`/api/permissions/${permissionId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const permission = data.permission;
                // Populate form fields
                // ... populate other fields
                new bootstrap.Modal(document.getElementById('editPermissionModal')).show();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while loading permission data');
        });
}

function deletePermission(permissionId) {
    if (confirm('Are you sure you want to delete this permission? This action cannot be undone.')) {
        fetch(`/api/permissions/${permissionId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Permission deleted successfully');
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while deleting the permission');
        });
    }
}

// Permission Grid functions
function initializePermissionGrid() {
    const gridBody = document.getElementById('permissionGridBody');
    const permissions = {{ json_encode($permissions->groupBy('module')) }};
    const roles = {{ json_encode($roles) }};
    
    let html = '';
    
    for (const [module, modulePermissions] of Object.entries(permissions)) {
        // Module header row
        html += `<tr class="module-header">
            <td colspan="${roles.length + 1}" class="fw-semibold">
                <i class="fas fa-cube me-2"></i>${module}
            </td>
        </tr>`;
        
        // Permission rows
        modulePermissions.forEach(permission => {
            html += `<tr>
                <td style="position: sticky; left: 0; background: white; z-index: 5;">
                    <div class="fw-semibold">${permission.display_name}</div>
                    <div class="text-muted small">${permission.description}</div>
                </td>`;
            
            roles.forEach(role => {
                const hasPermission = role.permissions?.some(p => p.id === permission.id) || false;
                html += `<td class="permission-cell">
                    <input type="checkbox" class="form-check-input permission-checkbox" 
                           data-role-id="${role.id}" data-permission-id="${permission.id}"
                           ${hasPermission ? 'checked' : ''}>
                </td>`;
            });
            
            html += '</tr>';
        });
    }
    
    gridBody.innerHTML = html;
    
    // Add event listeners for checkboxes
    document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const roleId = this.dataset.roleId;
            const permissionId = this.dataset.permissionId;
            const isChecked = this.checked;
            
            if (!permissionGridData[roleId]) {
                permissionGridData[roleId] = {};
            }
            permissionGridData[roleId][permissionId] = isChecked;
        });
    });
}

function saveGridChanges() {
    fetch('/partner/settings/permissions/bulk-update', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ changes: permissionGridData })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast('Permission grid updated successfully', 'success');
            permissionGridData = {};
            // Trigger real-time update
            broadcastPermissionUpdate();
        } else {
            showToast('Error: ' + data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('An error occurred while updating the permission grid', 'error');
    });
}

function expandAll() {
    document.querySelectorAll('.module-header').forEach(header => {
        header.classList.add('expanded');
        const moduleRows = [];
        let currentRow = header.nextElementSibling;
        while (currentRow && !currentRow.classList.contains('module-header')) {
            moduleRows.push(currentRow);
            currentRow = currentRow.nextElementSibling;
        }
        moduleRows.forEach(row => row.style.display = '');
    });
}

function collapseAll() {
    document.querySelectorAll('.module-header').forEach(header => {
        header.classList.remove('expanded');
        const moduleRows = [];
        let currentRow = header.nextElementSibling;
        while (currentRow && !currentRow.classList.contains('module-header')) {
            moduleRows.push(currentRow);
            currentRow = currentRow.nextElementSibling;
        }
        moduleRows.forEach(row => row.style.display = 'none');
    });
}

// Hierarchy functions
function initializeHierarchy() {
    const hierarchyTree = document.getElementById('hierarchyTree');
    const roles = {{ json_encode($roles) }};
    
    // Build hierarchy tree
    const treeData = buildHierarchyTree(roles);
    hierarchyTree.innerHTML = renderHierarchyTree(treeData);
    
    // Update hierarchy statistics
    updateHierarchyStats(roles);
}

function buildHierarchyTree(roles) {
    const tree = {};
    const roleMap = {};
    
    // Create role map
    roles.forEach(role => {
        roleMap[role.id] = { ...role, children: [] };
    });
    
    // Build tree structure
    roles.forEach(role => {
        if (role.parent_role_id && roleMap[role.parent_role_id]) {
            roleMap[role.parent_role_id].children.push(roleMap[role.id]);
        } else if (!role.parent_role_id) {
            tree[role.id] = roleMap[role.id];
        }
    });
    
    return tree;
}

function renderHierarchyTree(tree, level = 0) {
    let html = '';
    
    Object.values(tree).forEach(role => {
        const indent = '  '.repeat(level);
        html += `${indent}<div class="tree-node">
            <i class="fas fa-user-tag me-2"></i>
            <strong>${role.display_name}</strong>
            <span class="badge bg-secondary ms-2">${role.users?.length || 0} users</span>
        </div>`;
        
        if (role.children.length > 0) {
            html += renderHierarchyTree({ ...role.children }, level + 1);
        }
    });
    
    return html;
}

function updateHierarchyStats(roles) {
    const statsContainer = document.getElementById('hierarchyStats');
    const totalRoles = roles.length;
    const rootRoles = roles.filter(role => !role.parent_role_id).length;
    const maxDepth = calculateMaxDepth(roles);
    const totalUsers = roles.reduce((sum, role) => sum + (role.users?.length || 0), 0);
    
    statsContainer.innerHTML = `
        <div class="mb-3">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span>Total Roles:</span>
                <span class="badge bg-primary">${totalRoles}</span>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span>Root Roles:</span>
                <span class="badge bg-success">${rootRoles}</span>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span>Max Depth:</span>
                <span class="badge bg-info">${maxDepth}</span>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span>Total Users:</span>
                <span class="badge bg-warning">${totalUsers}</span>
            </div>
        </div>
    `;
}

function calculateMaxDepth(roles) {
    const roleMap = {};
    roles.forEach(role => {
        roleMap[role.id] = { ...role, depth: 0 };
    });
    
    let maxDepth = 0;
    
    function calculateDepth(roleId, currentDepth = 0) {
        const role = roleMap[roleId];
        if (!role) return currentDepth;
        
        role.depth = Math.max(role.depth, currentDepth);
        maxDepth = Math.max(maxDepth, currentDepth);
        
        if (role.parent_role_id) {
            calculateDepth(role.parent_role_id, currentDepth + 1);
        }
    }
    
    roles.forEach(role => {
        calculateDepth(role.id);
    });
    
    return maxDepth;
}

function refreshHierarchy() {
    initializeHierarchy();
}

// Export functions
function exportRoles() {
    window.location.href = '/api/roles/export';
}

function editRoleFromView() {
    bootstrap.Modal.getInstance(document.getElementById('viewRoleModal')).hide();
    editRole(currentRoleId);
}
</script>
@endsection
