<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Kelola User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div id="users-container">
                        <p class="text-gray-600 dark:text-gray-400">Loading users...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Fetch users dari API
        fetch('/api/admin/users', {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(users => {
            const container = document.getElementById('users-container');
            
            if (users.length === 0) {
                container.innerHTML = '<p class="text-gray-600 dark:text-gray-400">Tidak ada user.</p>';
                return;
            }

            let html = '<div class="overflow-x-auto"><table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">';
            html += '<thead class="bg-gray-50 dark:bg-gray-900"><tr>';
            html += '<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nama</th>';
            html += '<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Email</th>';
            html += '<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Role</th>';
            html += '<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Terdaftar</th>';
            html += '@if(Auth::user()->isSuperAdmin())<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aksi</th>@endif';
            html += '</tr></thead><tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">';

            users.forEach(user => {
                html += '<tr>';
                html += `<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">${user.name}</td>`;
                html += `<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">${user.email}</td>`;
                html += `<td class="px-6 py-4 whitespace-nowrap"><span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${getRoleBadgeClass(user.role)}">${user.role}</span></td>`;
                html += `<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">${new Date(user.created_at).toLocaleDateString('id-ID')}</td>`;
                
                @if(Auth::user()->isSuperAdmin())
                if (user.role !== 'superadmin') {
                    html += `<td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <button onclick="changeRole(${user.id}, '${user.role}')" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 mr-3">Edit Role</button>
                        <button onclick="deleteUser(${user.id})" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">Hapus</button>
                    </td>`;
                } else {
                    html += `<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">-</td>`;
                }
                @endif
                
                html += '</tr>';
            });

            html += '</tbody></table></div>';
            container.innerHTML = html;
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('users-container').innerHTML = 
                `<div class="text-red-600">
                    <p class="font-semibold">Error loading users</p>
                    <p class="text-sm mt-1">${error.message}</p>
                </div>`;
        });

        function getRoleBadgeClass(role) {
            switch(role) {
                case 'superadmin': return 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200';
                case 'admin': return 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200';
                default: return 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200';
            }
        }

        @if(Auth::user()->isSuperAdmin())
        function changeRole(userId, currentRole) {
            const newRole = currentRole === 'admin' ? 'user' : 'admin';
            
            if (!confirm(`Ubah role menjadi ${newRole}?`)) return;

            fetch(`/api/admin/users/${userId}/role`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ role: newRole })
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                location.reload();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Gagal mengubah role');
            });
        }

        function deleteUser(userId) {
            if (!confirm('Yakin ingin menghapus user ini?')) return;

            fetch(`/api/admin/users/${userId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                location.reload();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Gagal menghapus user');
            });
        }
        @endif
    </script>
</x-app-layout>