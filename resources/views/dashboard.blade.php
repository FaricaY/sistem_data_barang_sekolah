<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartAssets Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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
                        <img src="{{ asset('storage/' . Auth::user()->profile->profile_photo_path) }}" alt="User Photo" class="w-full h-full object-cover">
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
        <main class="ml-64 flex-1 p-8 overflow-y-auto">
            @if(Auth::user())
                <h2 class="text-3xl font-bold text-gray-800">Welcome back, {{ Auth::user()->name }}!</h2>
                <p class="text-gray-600 mb-8">It is time to manage your inventory</p>
            @endif

            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white p-6 rounded-2xl shadow-xl border-t-4 border-purple-500 hover:shadow-2xl transition duration-300">
                    <p class="text-purple-700 font-semibold text-sm uppercase">Total Items</p>
                    <h3 class="text-4xl font-extrabold text-gray-900 mt-1">{{ $stats['total_items'] ?? 0 }}</h3>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-xl border-t-4 border-pink-500 hover:shadow-2xl transition duration-300">
                    <p class="text-pink-700 font-semibold text-sm uppercase">Items In Stock</p>
                    <h3 class="text-4xl font-extrabold text-gray-900 mt-1">{{ $stats['items_in'] ?? 0 }}</h3>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-xl border-t-4 border-yellow-500 hover:shadow-2xl transition duration-300">
                    <p class="text-yellow-700 font-semibold text-sm uppercase">Items Issued/Out</p>
                    <h3 class="text-4xl font-extrabold text-gray-900 mt-1">{{ $stats['items_out'] ?? 0 }}</h3>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-xl border-t-4 border-green-500 hover:shadow-2xl transition duration-300">
                    <p class="text-green-700 font-semibold text-sm uppercase">Total Asset Value</p>
                    <h3 class="text-4xl font-extrabold text-gray-900 mt-1">${{ number_format($stats['total_value'] ?? 0, 0, '.', ',') }}</h3>
                </div>
            </div>

            <!-- Chart -->
            <div class="bg-white p-6 rounded-2xl shadow-xl mb-8">
                <h3 class="text-xl font-bold text-gray-700 mb-4 border-b pb-2">6-Month Inventory Trend</h3>
                <div style="height: 300px;">
                    <canvas id="itemsChart"></canvas>
                </div>
            </div>

            <!-- Bottom Cards -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white p-6 rounded-2xl shadow-xl border-l-4 border-blue-500">
                    <h3 class="font-bold text-lg text-gray-800">Status Indicators</h3>
                    <p class="text-sm text-gray-500 mb-3">Key procurement items for the quarter.</p>
                    <ul class="list-disc list-inside space-y-1 text-gray-700">
                        <li>10 Laptops (Pending Order)</li>
                        <li>5 Projectors (Awaiting Delivery)</li>
                    </ul>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-xl border-l-4 border-orange-500">
                    <h3 class="font-bold text-lg text-gray-800">Inventory Goals</h3>
                    <p class="text-sm text-gray-500 mb-3">Maintenance schedule and immediate needs.</p>
                    <ul class="list-disc list-inside space-y-1 text-gray-700">
                        <li>AC Service (Scheduled Next Week)</li>
                        <li>Chair Repairs (5 units needed)</li>
                    </ul>
                </div>
            </div>
        </main>
    </div>

    <!-- Chart.js Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('itemsChart');
            if (ctx) {
                new Chart(ctx.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: @json($chart['months'] ?? []), 
                        datasets: [
                            {
                                label: 'Items In',
                                data: @json($chart['items_in'] ?? []),
                                backgroundColor: '#a78bfa',
                                borderRadius: 5
                            },
                            {
                                label: 'Damaged',
                                data: @json($chart['damaged'] ?? []),
                                backgroundColor: '#f472b6',
                                borderRadius: 5
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { 
                            legend: { 
                                position: 'top',
                                labels: {
                                    font: { family: 'Inter', weight: '600' }
                                }
                            },
                            tooltip: { mode: 'index', intersect: false }
                        },
                        scales: { 
                            y: { 
                                beginAtZero: true,
                                grid: { color: 'rgba(0, 0, 0, 0.05)' }
                            },
                            x: {
                                grid: { display: false }
                            }
                        }
                    }
                });
            }
        });
    </script>
</body>
</html>