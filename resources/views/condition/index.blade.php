<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartAssets - Item Conditions</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
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

        <!-- Main Content -->
        <main class="ml-64 p-8 flex flex-col h-screen w-full">
            <div class="bg-white p-6 rounded-lg shadow-xl flex flex-col flex-grow">
                <!-- Header: Title and Add Button -->
                <div class="flex-shrink-0">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-bold text-gray-800">Manage Item Conditions</h1>
                        <a href="{{ route('condition.create') }}" class="bg-purple-500 text-white font-semibold px-4 py-2 rounded-lg flex items-center space-x-2 hover:bg-purple-600 transition">
                            <i class="fas fa-plus"></i>
                            <span>Add New Condition</span>
                        </a>
                    </div>
                
                    @if (session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif
                </div>
            
                <!-- Table Container -->
                <div class="flex-grow overflow-y-auto">
                    <table class="min-w-full text-left">
                        <thead class="border-b-2 border-gray-200 sticky top-0 bg-white">
                            <tr>
                                <th class="p-4 font-semibold text-gray-600">ID</th>
                                <th class="p-4 font-semibold text-gray-600">Condition Name</th>
                                <th class="p-4 font-semibold text-gray-600">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($conditions as $condition)
                                <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                                    <td class="p-4 text-gray-800">{{ $condition->id }}</td>
                                    <td class="p-4 text-gray-800 font-medium">{{ $condition->condition_name }}</td>
                                    <td class="p-4">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('condition.edit', $condition->id) }}" title="Edit" class="bg-gray-200 p-2 rounded-md hover:bg-gray-300 transition">
                                                <i class="fas fa-pencil-alt text-gray-600 w-4 h-4"></i>
                                            </a>
                                            <form action="{{ route('condition.destroy', $condition->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" title="Delete" class="bg-gray-200 p-2 rounded-md hover:bg-gray-300 transition">
                                                    <i class="fas fa-trash-alt text-gray-600 w-4 h-4"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="p-8 text-center text-gray-500">
                                        No conditions found. <a href="{{ route('condition.create') }}" class="text-purple-500 hover:underline">Add one now!</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            
                <!-- Pagination -->
                <div class="mt-6 flex-shrink-0">
                    {{ $conditions->links() }}
                </div>
            </div>
        </main>
    </div>
</body>
</html>