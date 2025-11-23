<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartAssets Inventory</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">

        <!-- Sidebar -->
        <aside class="fixed top-0 left-0 h-screen w-64 bg-purple-600 text-white flex flex-col shadow-2xl z-20">
            <div class="p-6">
                <h1 class="text-2xl font-bold">Smart<span class="text-pink-300">Assets</span></h1>
            </div>

            <div class="flex flex-col items-center bg-purple-700/50 rounded-xl p-4 mx-4 mb-6 shadow-inner">
                <div class="w-16 h-16 rounded-full bg-pink-300 flex items-center justify-center border-2 border-white overflow-hidden">
                    {{-- FIX: Use optional() to access the profile relationship --}}
                    @if(optional(Auth::user()->profile)->profile_photo_path)
                        <img src="{{ asset('storage/'. Auth::user()->profile->profile_photo_path) }}" alt="User Photo" class="w-full h-full object-cover">
                    @else
                        <i class="fas fa-user text-purple-800 text-2xl"></i>
                    @endif
                </div>
                <div class="text-center mt-3">
                    <h2 class="text-sm font-semibold">{{ Auth::user()->name ?? 'Guest User' }}</h2>
                    <p class="text-xs text-gray-200 break-words max-w-[150px] mx-auto">{{ Auth::user()->email ?? 'N/A' }}</p>
                </div>
            </div>

            <nav class="flex-1 px-4 space-y-2 overflow-y-auto">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 p-3 rounded-xl transition duration-200 hover:bg-white hover:text-purple-600 {{ request()->routeIs('dashboard') ? 'bg-white text-purple-600 font-bold shadow-md' : 'text-white' }}">
                    <i class="fas fa-th-large w-5"></i><span>Dashboard</span>
                </a>
                <a href="{{ route('items.index') }}" class="flex items-center space-x-3 p-3 rounded-xl transition duration-200 hover:bg-white hover:text-purple-600 {{ request()->routeIs('items.*') ? 'bg-white text-purple-600 font-bold shadow-md' : 'text-white' }}">
                    <i class="fas fa-database w-5"></i><span>Data</span>
                </a>
                <a href="{{ route('categories.index') }}" class="flex items-center space-x-3 p-3 rounded-xl transition duration-200 hover:bg-white hover:text-purple-600 {{ request()->routeIs('categories.*') ? 'bg-white text-purple-600 font-bold shadow-md' : 'text-white' }}">
                    <i class="fas fa-th-list w-5"></i><span>Categories</span>
                </a>
                <a href="{{ route('condition.index') }}" class="flex items-center space-x-3 p-3 rounded-xl transition duration-200 hover:bg-white hover:text-purple-600 {{ request()->routeIs('condition.*') ? 'bg-white text-purple-600 font-bold shadow-md' : 'text-white' }}">
                    <i class="fas fa-tools w-5"></i><span>Item Condition</span>
                </a>
                <a href="{{ route('settings') }}" class="flex items-center space-x-3 p-3 rounded-xl transition duration-200 hover:bg-white hover:text-purple-600 {{ request()->routeIs('settings') || request()->routeIs('profile.edit') ? 'bg-white text-purple-600 font-bold shadow-md' : 'text-white' }}">
                    <i class="fas fa-cog w-5"></i><span>Settings</span>
                </a>
                
                <a href="{{ route('help.index') }}" class="flex items-center space-x-3 p-3 rounded-xl transition duration-200 hover:bg-white hover:text-purple-600 {{ request()->routeIs('help.index') ? 'bg-white text-purple-600 font-bold shadow-md' : 'text-white' }}">
                    <i class="fas fa-question-circle w-5"></i><span>Help</span>
                </a>
            </nav>

            <div class="p-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center space-x-3 w-full p-3 rounded-xl text-white bg-purple-700 hover:bg-pink-300 hover:text-purple-900 transition font-semibold shadow-lg justify-center">
                        <i class="fas fa-sign-out-alt"></i><span>Log out</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Wrapper -->
        <main class="ml-64 p-8 flex flex-col h-screen w-full">
            <div class="bg-white p-6 rounded-lg shadow-xl flex flex-col flex-grow">
    
                <!-- Header -->
                <div class="flex-shrink-0">
                    <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
                        <div class="relative w-full sm:w-1/3">
                            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input type="text" id="searchInput" placeholder="Search" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 transition">
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center space-x-2 text-gray-600">
                                <span>Showing</span>
                                <select id="itemsPerPageSelector" class="border border-gray-300 rounded-lg px-3 py-1.5 focus:outline-none focus:ring-2 focus:ring-purple-500 transition">
                                    <option value="7">7</option>
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                </select>
                            </div>
                            <a href="{{ route('items.create') }}" class="bg-purple-500 text-white font-semibold px-4 py-2 rounded-lg flex items-center space-x-2 hover:bg-purple-600 transition shadow-md hover:shadow-lg">
                                <i class="fas fa-plus"></i>
                                <span>Add New Item</span>
                            </a>
                        </div>
                    </div>
                
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">School Inventory</h2>
                </div>
            
                <!-- Inventory Table -->
                <div class="flex-grow overflow-y-auto">
                    <table class="min-w-full text-left">
                        <thead class="border-b-2 border-gray-200 sticky top-0 bg-white">
                            <tr>
                                <th class="p-4 font-semibold text-gray-600">ID</th>
                                <th class="p-4 font-semibold text-gray-600">Code</th>
                                <th class="p-4 font-semibold text-gray-600">Name</th>
                                <th class="p-4 font-semibold text-gray-600">Category</th>
                                <th class="p-4 font-semibold text-gray-600">Condition</th>
                                <th class="p-4 font-semibold text-gray-600">Quantity</th>
                                <th class="p-4 font-semibold text-gray-600">Location</th>
                                <th class="p-4 font-semibold text-gray-600">Action</th>
                            </tr>
                        </thead>
                        <tbody id="inventoryTableBody">
                            @forelse($items as $item)
                                <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                                    <td class="p-4 text-gray-800">{{ $item->id }}</td>
                                    <td class="p-4 text-gray-800 font-medium">#{{ $item->code }}</td>
                                    <td class="p-4 text-gray-800">{{ $item->name }}</td>
                                    <td class="p-4 text-gray-800">{{ $item->category->category_name ?? 'N/A' }}</td>
                                    <td class="p-4 text-gray-800">{{ $item->condition->condition_name ?? 'N/A' }}</td>
                                    <td class="p-4 text-gray-800">{{ $item->quantity }}</td>
                                    <td class="p-4 text-gray-800">{{ $item->location }}</td>
                                    <td class="p-4">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('items.edit', $item->id) }}" title="Edit" class="bg-gray-200 p-2 rounded-md hover:bg-gray-300 transition">
                                                <i class="fas fa-pencil-alt text-gray-600 w-4 h-4"></i>
                                            </a>
                                            <button type="button" title="Delete" class="js-delete-trigger bg-gray-200 p-2 rounded-md hover:bg-gray-300 transition" data-item-id="{{ $item->id }}">
                                                <i class="fas fa-trash-alt text-gray-600 w-4 h-4"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="p-8 text-center text-gray-500">
                                        There is no data, you can <a href="{{ route('items.create') }}" class="text-purple-500 hover:underline font-semibold">add it</a>.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            
                <!-- Pagination -->
                <div class="mt-6 flex-shrink-0">
                    {{ $items->links() }}
                </div>
            </div>
        </main>
    </div>

    <!-- Delete Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-900 bg-opacity-75 z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-xl shadow-2xl p-6 w-full max-w-sm">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                    <i class="fas fa-exclamation-triangle text-red-600 text-2xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mt-3">Confirm Deletion</h3>
                <p class="text-sm text-gray-500 mt-2">Are you sure you want to delete this item? This action is permanent.</p>
            </div>
            <form id="deleteForm" method="POST" action="">
                @csrf
                @method('DELETE')
                <div class="mt-5 sm:mt-6 flex justify-between space-x-3">
                    <button type="button" id="cancelDelete" class="w-full inline-flex justify-center rounded-lg border border-gray-300 px-4 py-2 bg-white font-medium text-gray-700 hover:bg-gray-50 transition">
                        Cancel
                    </button>
                    <button type="submit" class="w-full inline-flex justify-center rounded-lg border border-transparent px-4 py-2 bg-red-600 font-medium text-white hover:bg-red-700 transition">
                        Delete
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const deleteModal = document.getElementById('deleteModal');
            const deleteForm = document.getElementById('deleteForm');
            const cancelDeleteBtn = document.getElementById('cancelDelete');

            document.querySelectorAll('.js-delete-trigger').forEach(button => {
                button.addEventListener('click', function() {
                    const itemId = this.getAttribute('data-item-id');
                    // Correctly form the action URL based on your named routes
                    const actionUrl = `{{ url('items') }}/${itemId}`;
                    deleteForm.setAttribute('action', actionUrl);
                    deleteModal.classList.remove('hidden');
                });
            });

            const closeModal = () => {
                deleteModal.classList.add('hidden');
            };

            cancelDeleteBtn.addEventListener('click', closeModal);
            deleteModal.addEventListener('click', (event) => {
                if (event.target === deleteModal) {
                    closeModal();
                }
            });
        });
    </script>
</body>
</html>