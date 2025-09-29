<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
        <p class="text-sm text-gray-500">Total Users</p>
        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $totalUsers ?? 0 }}</p>
    </div>
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
        <p class="text-sm text-gray-500">Active Users</p>
        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $activeUsers ?? 0 }}</p>
    </div>
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
        <p class="text-sm text-gray-500">Pending Users</p>
        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $pendingUsers ?? 0 }}</p>
    </div>
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
        <p class="text-sm text-gray-500">Suspended Users</p>
        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $suspendedUsers ?? 0 }}</p>
    </div>
</div>

<div class="bg-white dark:bg-gray-800 shadow rounded-lg mb-6 overflow-hidden">
    <div class="flex items-center justify-between p-4 border-b border-gray-100 dark:border-gray-700">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">User List</h3>
        <button id="openAddUser" class="inline-flex items-center gap-2 px-4 py-2 bg-primaryGreen text-white rounded-lg shadow hover:bg-primaryGreen/90">
            <i class="fas fa-plus"></i>
            <span>Add New User</span>
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-900">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-100 dark:divide-gray-700">
                @forelse($users as $user)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $user->role ?? 'N/A' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($user->status == 'active')
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">Active</span>
                        @elseif($user->status == 'pending')
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">Pending</span>
                        @else
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">Suspended</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right">
                        <button class="inline-flex items-center px-3 py-1 rounded-md bg-blue-600 text-white text-sm mr-2" title="Edit User"><i class="fas fa-edit"></i></button>
                        <button class="inline-flex items-center px-3 py-1 rounded-md bg-red-600 text-white text-sm" title="Delete User"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-sm text-gray-500">No users found for this partner.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Add User Modal (Tailwind) -->
<div id="addUserModal" class="fixed inset-0 z-40 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl w-11/12 max-w-2xl">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Add New User</h3>
            <button id="closeAddUser" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">&times;</button>
        </div>
        <div class="px-6 py-4">
            <form id="addUserForm">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                        <input id="userName" type="text" class="mt-1 block w-full px-3 py-2 border rounded-lg bg-gray-50 dark:bg-gray-700 dark:text-white" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                        <input id="userEmail" type="email" class="mt-1 block w-full px-3 py-2 border rounded-lg bg-gray-50 dark:bg-gray-700 dark:text-white" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                        <input id="userPassword" type="password" class="mt-1 block w-full px-3 py-2 border rounded-lg bg-gray-50 dark:bg-gray-700 dark:text-white" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Role</label>
                        <select id="userRole" class="mt-1 block w-full px-3 py-2 border rounded-lg bg-gray-50 dark:bg-gray-700 dark:text-white" required>
                            <option selected disabled value="">Select a role</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                        <select id="userStatus" class="mt-1 block w-full px-3 py-2 border rounded-lg bg-gray-50 dark:bg-gray-700 dark:text-white" required>
                            <option value="active">Active</option>
                            <option value="pending">Pending</option>
                            <option value="suspended">Suspended</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>
        <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700 flex justify-end gap-3">
            <button id="cancelAddUser" class="px-4 py-2 bg-gray-200 rounded-md">Close</button>
            <button id="saveAddUser" class="px-4 py-2 bg-primaryGreen text-white rounded-md">Save User</button>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const open = document.getElementById('openAddUser');
    const modal = document.getElementById('addUserModal');
    const close = document.getElementById('closeAddUser');
    const cancel = document.getElementById('cancelAddUser');

    function showModal() { modal.classList.remove('hidden'); }
    function hideModal() { modal.classList.add('hidden'); }

    if (open) open.addEventListener('click', showModal);
    if (close) close.addEventListener('click', hideModal);
    if (cancel) cancel.addEventListener('click', hideModal);

    // Save user (client-side demo)
    const saveBtn = document.getElementById('saveAddUser');
    if (saveBtn) {
        saveBtn.addEventListener('click', function() {
            // TODO: implement ajax save
            hideModal();
            alert('User saved (demo)');
        });
    }
});
</script>
@endpush
