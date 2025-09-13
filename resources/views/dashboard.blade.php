<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartAssets Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-gray-100">

    <!-- Sidebar -->
    <aside class="fixed top-0 left-0 h-screen w-64 bg-purple-500 text-white flex flex-col">
        <!-- Logo -->
        <div class="p-6">
            <h1 class="text-2xl font-bold">Smart<span class="text-pink-200">Assets</span></h1>
        </div>

        <!-- User -->
        <div class="flex flex-col items-center bg-purple-400 rounded-xl p-4 mx-4 mb-6">
            <div class="w-16 h-16 rounded-full bg-gray-200 flex items-center justify-center">
                <i class="fas fa-user text-gray-500 text-2xl"></i>
            </div>
            <div class="text-center mt-3">
                <h2 class="text-sm font-semibold">{{ $user->name }}</h2>
                <p class="text-xs text-gray-100 break-words max-w-[150px] mx-auto">{{ $user->email }}</p>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-4 space-y-2 overflow-y-auto">
            <a href="{{ route('dashboard') }}" 
               class="flex items-center space-x-2 p-3 rounded-lg transition 
                      hover:bg-white hover:text-purple-600 {{ request()->routeIs('dashboard') ? 'bg-white text-purple-600' : '' }}">
                <i class="fas fa-th-large"></i><span>Dashboard</span>
            </a>
            <a href="{{ route('data') }}" 
               class="flex items-center space-x-2 p-3 rounded-lg transition 
                      hover:bg-white hover:text-purple-600 {{ request()->routeIs('data') ? 'bg-white text-purple-600' : '' }}">
                <i class="fas fa-database"></i><span>Data</span>
            </a>
            <a href="{{ route('category') }}" 
               class="flex items-center space-x-2 p-3 rounded-lg transition 
                      hover:bg-white hover:text-purple-600 {{ request()->routeIs('category') ? 'bg-white text-purple-600' : '' }}">
                <i class="fas fa-th-list"></i><span>Category</span>
            </a>
            <a href="{{ route('item-condition') }}" 
               class="flex items-center space-x-2 p-3 rounded-lg transition 
                      hover:bg-white hover:text-purple-600 {{ request()->routeIs('item-condition') ? 'bg-white text-purple-600' : '' }}">
                <i class="fas fa-tools"></i><span>Item Condition</span>
            </a>
            <a href="{{ route('settings') }}" 
               class="flex items-center space-x-2 p-3 rounded-lg transition 
                      hover:bg-white hover:text-purple-600 {{ request()->routeIs('settings') ? 'bg-white text-purple-600' : '' }}">
                <i class="fas fa-cog"></i><span>Settings</span>
            </a>
            <a href="{{ route('help') }}" 
               class="flex items-center space-x-2 p-3 rounded-lg transition 
                      hover:bg-white hover:text-purple-600 {{ request()->routeIs('help') ? 'bg-white text-purple-600' : '' }}">
                <i class="fas fa-question-circle"></i><span>Help</span>
            </a>
        </nav>

        <!-- Logout Button (sticks bottom) -->
        <form method="POST" action="{{ route('logout') }}" class="p-4">
            @csrf
            <button type="submit" 
                    class="flex items-center space-x-2 w-full p-3 rounded-lg hover:bg-white hover:text-purple-600 transition">
                <i class="fas fa-sign-out-alt"></i><span>Log out</span>
            </button>
        </form>
    </aside>

    <!-- Main Content -->
    <main class="ml-64 p-6 overflow-y-auto h-screen">
        <h2 class="text-2xl font-bold">Welcome back, {{ $user->name }}!</h2>
        <p class="text-gray-600 mb-6">It is time to manage your inventory</p>

        <!-- Stats -->
        <div class="grid grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-lg shadow text-center">
                <p class="text-purple-500 font-semibold">Total items</p>
                <h3 class="text-2xl font-bold">{{ $stats['total_items'] }}</h3>
            </div>
            <div class="bg-white p-6 rounded-lg shadow text-center">
                <p class="text-purple-500 font-semibold">Items in</p>
                <h3 class="text-2xl font-bold">{{ $stats['items_in'] }}</h3>
            </div>
            <div class="bg-white p-6 rounded-lg shadow text-center">
                <p class="text-purple-500 font-semibold">Items out</p>
                <h3 class="text-2xl font-bold">{{ $stats['items_out'] }}</h3>
            </div>
            <div class="bg-white p-6 rounded-lg shadow text-center">
                <p class="text-purple-500 font-semibold">Total value</p>
                <h3 class="text-2xl font-bold">${{ number_format($stats['total_value'], 0) }}</h3>
            </div>
        </div>

        <!-- Chart -->
        <div class="bg-white p-6 rounded-lg shadow mb-8">
            <h3 class="text-lg font-bold text-gray-700 mb-4">Items In vs Damaged Chart</h3>
            <canvas id="itemsChart" height="120"></canvas>
        </div>

        <!-- Bottom Cards -->
        <div class="grid grid-cols-2 gap-6">
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="font-bold text-gray-700">Status Indicators</h3>
                <p class="text-sm text-gray-500">Procurement Plan</p>
                <p class="mt-2">10 Laptops, 5 projectors</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="font-bold text-gray-700">Inventory Goals</h3>
                <p class="text-sm text-gray-500">Maintenance</p>
                <p class="mt-2">AC service, chair repairs</p>
            </div>
        </div>
    </main>

    <!-- Chart.js Script -->
    <script>
        const ctx = document.getElementById('itemsChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($chart['months']),
                datasets: [
                    {
                        label: 'Items In',
                        data: @json($chart['items_in']),
                        backgroundColor: '#a78bfa'
                    },
                    {
                        label: 'Damaged',
                        data: @json($chart['damaged']),
                        backgroundColor: '#f472b6'
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'top' } },
                scales: { y: { beginAtZero: true } }
            }
        });
    </script>

</body>
</html>
