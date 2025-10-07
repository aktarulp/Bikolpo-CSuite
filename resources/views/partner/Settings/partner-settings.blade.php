@extends('layouts.partner-layout')

@section('title', 'Partner Settings')

@section('content')
<div class="min-h-screen bg-gray-50/50 p-4 sm:p-6">
    <!-- Page Header -->
    <div class="mb-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 sm:p-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800 mb-1">
                        Partner Settings
                    </h1>
                    <p class="text-gray-500 text-sm">
                        Manage your organization settings, users, and permissions
                    </p>
                </div>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('partner.settings.backup-restore') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-600 text-white text-sm font-medium rounded-lg hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-green-500/20 focus:ring-offset-1 transition-all active:scale-[0.98]">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                        Backup/Restore
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Overview -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        @php
            $statsCards = [
                [
                    'title' => 'Total Users',
                    'value' => $stats['total_users'] ?? 0,
                    'subtitle' => 'Active accounts',
                    'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z',
                    'color' => 'blue'
                ],
                [
                    'title' => 'Roles',
                    'value' => $stats['total_roles'] ?? 0,
                    'subtitle' => 'User roles defined',
                    'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',
                    'color' => 'green'
                ],
                [
                    'title' => 'Permissions',
                    'value' => 'Loading...',
                    'subtitle' => 'System permissions',
                    'icon' => 'M15 7a2 2 0 012 2m0 0a2 2 0 01-2 2m2-2h3m-3 0h-3m-2-5a2 2 0 00-2 2v6a2 2 0 002 2h6a2 2 0 002-2V9a2 2 0 00-2-2h-6z',
                    'color' => 'purple',
                    'id' => 'totalPermissionsCount'
                ],
                [
                    'title' => 'Organization',
                    'value' => $partner?->name ?? 'N/A',
                    'subtitle' => 'Your partner',
                    'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4',
                    'color' => 'orange',
                    'truncate' => true
                ]
            ];
        @endphp

        @foreach($statsCards as $card)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div class="min-w-0">
                    <p class="text-sm font-medium text-gray-500 mb-1">{{ $card['title'] }}</p>
                    <p @if(isset($card['id'])) id="{{ $card['id'] }}" @endif 
                       class="text-2xl font-bold text-gray-800 {{ isset($card['truncate']) ? 'truncate' : '' }}">
                        {{ $card['value'] }}
                    </p>
                    <p class="text-xs text-gray-400 mt-1">{{ $card['subtitle'] }}</p>
                </div>
                <div class="w-12 h-12 bg-{{ $card['color'] }}-50 rounded-xl flex items-center justify-center ml-4 flex-shrink-0">
                    <svg class="w-6 h-6 text-{{ $card['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card['icon'] }}"></path>
                    </svg>
                </div>
            </div>
        </div>
        @endforeach
    </div>


    <!-- User Management Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6 overflow-hidden">
        <!-- Header -->
        <div class="px-5 py-4 border-b border-gray-100 bg-gray-50/50">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">User Management</h3>
                    <p class="text-sm text-gray-500 mt-0.5">Manage all user accounts and their access</p>
                </div>
                <a href="{{ route('partner.settings.users.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white text-sm font-medium rounded-lg hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:ring-offset-1 transition-all active:scale-[0.98]">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Create User
                </a>
            </div>
        </div>
        
        <!-- Users Content -->
        <div class="p-1">
            @if($stats['users'] && $stats['users']->isNotEmpty())
                <!-- Desktop Table -->
                <div class="hidden sm:block overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
@foreach($stats['users'] as $user)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-5 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 font-medium">
                                                {{ substr($user->name, 0, 1) }}
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-600">{{ $user->email }}</div>
                                    </td>
                                    <td class="px-5 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            <span class="w-1.5 h-1.5 rounded-full {{ $user->status == 'active' ? 'bg-green-500' : 'bg-red-500' }} mr-1.5"></span>
                                            {{ ucfirst($user->status) }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-4 whitespace-nowrap">
                                        @if(isset($user->roles) && $user->roles && $user->roles->isNotEmpty())
                                            <div class="flex flex-wrap gap-1">
                                                @foreach($user->roles as $role)
                                                    <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-blue-50 text-blue-700">
                                                        {{ $role->display_name ?? ucwords(str_replace('_', ' ', $role->name ?? '')) }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-600">
                                                No Role
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Mobile Cards -->
                <div class="sm:hidden space-y-3 p-3">
@foreach($stats['users'] as $user)
                        <div class="bg-white rounded-xl border border-gray-100 p-4 shadow-xs hover:shadow-sm transition-shadow">
                            <div class="flex items-start justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 font-medium text-sm">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-900">{{ $user->name }}</h4>
                                        <p class="text-xs text-gray-500 mt-0.5">{{ $user->email }}</p>
                                    </div>
                                </div>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $user->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($user->status) }}
                                </span>
                            </div>
                            <div class="mt-3 flex items-center justify-between">
                                <div class="flex flex-wrap gap-1">
                                    @if(isset($user->roles) && $user->roles && $user->roles->isNotEmpty())
                                        @foreach($user->roles as $role)
                                            <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-blue-50 text-blue-700">
                                                {{ $role->display_name ?? ucwords(str_replace('_', ' ', $role->name ?? '')) }}
                                            </span>
                                        @endforeach
                                    @else
                                        <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-600">
                                            No Role
                                        </span>
                                    @endif
                                </div>
                                <a href="#" class="text-xs font-medium text-blue-600 hover:text-blue-800">View</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No users found</h3>
                    <p class="text-gray-600 mb-4">Users you create will be displayed here.</p>
                </div>
            @endif
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
// Load total permissions count
function loadPermissionsCount() {
    fetch('/api/permissions')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('totalPermissionsCount').textContent = data.permissions.length;
            }
        })
        .catch(error => {
            console.error('Error loading permissions count:', error);
            if (document.getElementById('totalPermissionsCount')) {
                document.getElementById('totalPermissionsCount').textContent = 'N/A';
            }
        });
}

                        <td class="py-4 px-6 hidden sm:table-cell">
                            <p class="text-sm text-gray-900 max-w-xs truncate">${activity.description || ''}</p>
                        </td>
                        <td class="py-4 px-6 hidden sm:table-cell">
                            <code class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-md">${activity.ip_address || 'N/A'}</code>
                        </td>
                        <td class="py-4 px-6 whitespace-nowrap">
                            <p class="text-sm text-gray-900">${formatTimestamp(activity.created_at)}</p>
                        </td>
                    </tr>
                `).join('');

                // Render mobile cards
                cards.innerHTML = data.activities.slice(0, 10).map(activity => `
                    <div class="activity-card bg-gray-50 border border-gray-200 rounded-lg p-4">
                        <div class="flex items-center mb-2">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-gray-400 to-gray-500 flex items-center justify-center mr-3 flex-shrink-0 shadow-sm">
                                <i class="fas fa-user text-white text-sm"></i>
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">${activity.user_name || 'Unknown User'}</p>
                                <p class="text-xs text-gray-500 truncate">${activity.user_email || ''}</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-between text-xs text-gray-500 mt-2">
                            <span class="badge ${getActionBadgeColor(activity.action)}">${formatAction(activity.action || '')}</span>
                            <span class="">${formatTimestamp(activity.created_at)}</span>
                        </div>
                        ${activity.description ? `<p class="text-sm text-gray-700 mt-2">${activity.description}</p>` : ''}
                        ${activity.ip_address ? `<code class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-md inline-block mt-2">${activity.ip_address}</code>` : ''}
                    </div>
                `).join('');
            } else {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="5" class="text-center py-12 text-gray-500">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-inbox text-3xl text-gray-300 mb-3"></i>
                                <p class="text-base font-medium text-gray-900">No activity found</p>
                                <p class="text-sm text-gray-500">There are no recent system activities to display</p>
                            </div>
                        </td>
                    </tr>
                `;
                cards.innerHTML = `
                    <div class="activity-card bg-gray-50 border border-gray-200 rounded-lg p-4">
                        <div class="flex items-center mb-2">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-gray-400 to-gray-500 flex items-center justify-center mr-3 flex-shrink-0 shadow-sm">
                                <i class="fas fa-inbox text-white text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">No activity found</p>
                                <p class="text-xs text-gray-500">There are no recent system activities to display</p>
                            </div>
                        </div>
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('Error loading recent activity:', error);
            const tbody = document.getElementById('recentActivityTable');
            const cards = document.getElementById('recentActivityCards');
            
            if (tbody) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="5" class="text-center py-12 text-gray-500">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-exclamation-triangle text-3xl text-gray-300 mb-3"></i>
                                <p class="text-base font-medium text-gray-900">Unable to load activity</p>
                                <p class="text-sm text-gray-500">Please check your connection and try again</p>
                            </div>
                        </td>
                    </tr>
                `;
            }
            
            if (cards) {
                cards.innerHTML = `
                    <div class="activity-card bg-gray-50 border border-gray-200 rounded-lg p-4">
                        <div class="flex items-center mb-2">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-red-400 to-red-500 flex items-center justify-center mr-3 flex-shrink-0 shadow-sm">
                                <i class="fas fa-exclamation-triangle text-white text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Unable to load activity</p>
                                <p class="text-xs text-gray-500">Please check your connection and try again</p>
                            </div>
                        </div>
                    </div>
                `;
            }
        });
}

// Helper functions
function getActionBadgeColor(action) {
    const colors = {
        'login': 'bg-green-100 text-green-800',
        'logout': 'bg-gray-100 text-gray-800',
        'create': 'bg-blue-100 text-blue-800',
        'update': 'bg-yellow-100 text-yellow-800',
        'delete': 'bg-red-100 text-red-800',
        'view': 'bg-purple-100 text-purple-800',
        'export': 'bg-indigo-100 text-indigo-800',
        'import': 'bg-pink-100 text-pink-800'
    };
    return colors[action?.toLowerCase()] || 'bg-gray-100 text-gray-800';
}

function formatAction(action) {
    if (!action) return 'Unknown';
    return action.charAt(0).toUpperCase() + action.slice(1).replace(/_/g, ' ');
}

function formatTimestamp(timestamp) {
    if (!timestamp) return 'N/A';
    const date = new Date(timestamp);
    const now = new Date();
    const diff = now - date;
    
    if (diff < 60000) return 'Just now';
    if (diff < 3600000) return `${Math.floor(diff / 60000)}m ago`;
    if (diff < 86400000) return `${Math.floor(diff / 3600000)}h ago`;
    if (diff < 604800000) return `${Math.floor(diff / 86400000)}d ago`;
    
    return date.toLocaleDateString();
}

// Refresh all data
function refreshData() {
    loadPermissionsCount();
    loadRecentActivity();
    
    // Show toast notification
    const toast = document.createElement('div');
    toast.className = 'fixed top-6 right-6 bg-white border border-gray-100 rounded-xl shadow-xl z-50 flex items-center p-4 min-w-[320px] backdrop-blur-sm';
    toast.style.background = 'linear-gradient(135deg, #ffffff 0%, #fafbfc 100%)';
    toast.setAttribute('role', 'alert');
    toast.innerHTML = `
        <div class="flex items-center">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center mr-3 shadow-sm">
                <i class="fas fa-check text-white"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-900">Data refreshed</p>
                <p class="text-xs text-gray-500">Statistics updated successfully</p>
            </div>
        </div>
    `;
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateX(100%)';
        toast.style.transition = 'all 0.3s ease';
        setTimeout(() => {
            toast.remove();
        }, 300);
    }, 3000);
}

// Initialize page
document.addEventListener('DOMContentLoaded', function() {
    loadPermissionsCount();
    loadRecentActivity();
    
    // Auto-refresh every 5 minutes
    setInterval(() => {
        loadRecentActivity();
    }, 300000);
});
</script>
@endsection
