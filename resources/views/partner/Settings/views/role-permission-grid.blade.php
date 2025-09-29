<div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mb-6">
    <div class="flex items-center justify-between p-4 border-b border-gray-100 dark:border-gray-700">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Role Management</h3>
        <button id="openAddRole" class="inline-flex items-center gap-2 px-4 py-2 bg-primaryGreen text-white rounded-lg shadow hover:bg-primaryGreen/90">
            <i class="fas fa-plus"></i>
            <span>Add New Role</span>
        </button>
    </div>
    <div class="p-4">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-900">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Users</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($roles as $role)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $role->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                    {{ $finalRoleUserCounts[$role->id] ?? 0 }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="flex items-center justify-end">
                                    <button class="inline-flex items-center px-3 py-1 rounded-md bg-blue-600 text-white text-sm mr-2" title="Edit Role"><i class="fas fa-edit"></i></button>
                                    <button class="inline-flex items-center px-3 py-1 rounded-md bg-red-600 text-white text-sm" title="Delete Role"><i class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-sm text-gray-500">No roles found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
    
<div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mb-6">
    <div class="p-4 border-b border-gray-100 dark:border-gray-700">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Permission Grid</h3>
    </div>
    <div class="p-4">
        <p class="text-sm text-gray-500 mb-4">Configure permissions for each role across different modules.</p>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-900">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Module</th>
                        @foreach($roles as $role)
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">{{ $role->name }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-100 dark:divide-gray-700">
                    @php
                        $modules = [
                            'Dashboard' => ['view'],
                            'Users' => ['view', 'create', 'edit', 'delete'],
                            'Settings' => ['view', 'edit'],
                            'Courses' => ['view', 'create', 'edit', 'delete'],
                        ];
                    @endphp

                    @foreach($modules as $moduleName => $modulePermissions)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $moduleName }}</td>
                            @foreach($roles as $role)
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center">
                                        <input type="checkbox" id="{{ Str::slug($role->name) }}-{{ Str::slug($moduleName) }}-view" class="form-checkbox h-5 w-5 text-primaryGreen rounded focus:ring-primaryGreen dark:bg-gray-700 dark:border-gray-600" {{ in_array('view', $modulePermissions) ? 'checked' : '' }}>
                                        <label for="{{ Str::slug($role->name) }}-{{ Str::slug($moduleName) }}-view" class="sr-only"></label>
                                    </div>
                                </td>
                            @endforeach
                        </tr>
                    @endforeach

                    @empty($modules)
                        <tr>
                            <td colspan="{{ count($roles) + 1 }}" class="px-6 py-8 text-center text-sm text-gray-500">No modules or permissions defined.</td>
                        </tr>
                    @endempty
                </tbody>
            </table>
        </div>
    </div>
</div>
    
<div class="flex justify-end mt-6">
    <button type="submit" class="inline-flex items-center px-4 py-2 bg-primaryGreen text-white font-medium rounded-md shadow-sm hover:bg-primaryGreen/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primaryGreen">Save Permissions</button>
</div>

<!-- Add Role Modal (Tailwind) -->
<div id="addRoleModal" class="fixed inset-0 z-40 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl w-11/12 max-w-2xl">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Add New Role</h3>
            <button id="closeAddRole" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">&times;</button>
        </div>
        <div class="px-6 py-4">
            <form id="addRoleForm">
                <div class="mb-4">
                    <label for="roleName" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Role Name</label>
                    <input type="text" class="mt-1 block w-full px-3 py-2 border rounded-lg bg-gray-50 dark:bg-gray-700 dark:text-white" id="roleName" required>
                </div>
                <div class="mb-4">
                    <label for="parentRole" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Parent Role (Optional)</label>
                    <select class="mt-1 block w-full px-3 py-2 border rounded-lg bg-gray-50 dark:bg-gray-700 dark:text-white" id="parentRole">
                        <option value="">None</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>
        <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700 flex justify-end gap-3">
            <button id="cancelAddRole" class="px-4 py-2 bg-gray-200 rounded-md">Close</button>
            <button id="saveAddRole" class="px-4 py-2 bg-primaryGreen text-white rounded-md">Save Role</button>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const openBtn = document.getElementById('openAddRole');
    const modal = document.getElementById('addRoleModal');
    const closeBtn = document.getElementById('closeAddRole');
    const cancelBtn = document.getElementById('cancelAddRole');
    const saveBtn = document.getElementById('saveAddRole');

    function showModal() { modal.classList.remove('hidden'); }
    function hideModal() { modal.classList.add('hidden'); }

    if (openBtn) openBtn.addEventListener('click', showModal);
    if (closeBtn) closeBtn.addEventListener('click', hideModal);
    if (cancelBtn) cancelBtn.addEventListener('click', hideModal);

    if (saveBtn) {
        saveBtn.addEventListener('click', function() {
            // TODO: Implement AJAX save functionality for adding a new role
            alert('Role saved (demo)');
            hideModal();
        });
    }
});
</script>
@endpush
