@extends('layouts.app')

@section('content')
    <h2 class="text-2xl font-bold">Data Management</h2>
    <p class="text-gray-600 mb-6">Manage all inventory items here</p>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="py-3 px-4">Name</th>
                    <th class="py-3 px-4">ID</th>
                    <th class="py-3 px-4">Value</th>
                    <th class="py-3 px-4">Stock</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items ?? [] as $item)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-2 px-4">{{ $item['name'] }}</td>
                        <td class="py-2 px-4">#{{ $item['id'] }}</td>
                        <td class="py-2 px-4">${{ $item['value'] }}</td>
                        <td class="py-2 px-4">{{ $item['stock'] ?? 'N/A' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection



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

        <!-- Logout Button -->
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
        @yield('content')
    </main>
</body>
</html>
