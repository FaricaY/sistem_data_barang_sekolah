<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartAssets - Settings</title>
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
        <aside class="fixed top-0 left-0 h-screen w-64 bg-purple-600 text-white flex flex-col shadow-2xl z-20">
            <div class="p-6">
                <h1 class="text-2xl font-bold">Smart<span class="text-pink-300">Assets</span></h1>
            </div>

            <div class="flex flex-col items-center bg-purple-700/50 rounded-xl p-4 mx-4 mb-6 shadow-inner">
                <div class="w-16 h-16 rounded-full bg-pink-300 flex items-center justify-center border-2 border-white overflow-hidden">
                    {{-- FIX: Use optional() and access profile relation --}}
                    @if(Auth::user() && optional(Auth::user()->profile)->profile_photo_path)
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

        <main class="ml-64 p-8 w-full">
            
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-gray-800">General Settings</h1>
                <a href="{{ route('profile.edit') }}" class="bg-purple-500 text-white font-semibold px-4 py-2 rounded-lg flex items-center space-x-2 hover:bg-purple-600 transition shadow-md">
                    <i class="fas fa-pencil-alt w-4 h-4"></i>
                    <span>Edit Profile</span>
                </a>
            </div>

            {{-- FIX: Renamed session key to 'status' to match controller --}}
            @if (session('status'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md shadow-sm" role="alert">
                    <p>{{ session('status') }}</p>
                </div>
            @endif

            <div class="bg-white rounded-lg shadow-xl p-8">
                <div class="space-y-6">
                    <div class="flex items-center mb-6">
                        <div class="w-24 h-24 rounded-full bg-gray-300 mr-6 flex items-center justify-center overflow-hidden">
                            {{-- FIX: Use optional() and access profile relation --}}
                            @if(Auth::user() && optional(Auth::user()->profile)->profile_photo_path)
                                <img src="{{ asset('storage/' . Auth::user()->profile->profile_photo_path) }}" alt="Profile Picture" class="w-full h-full object-cover">
                            @else
                                <i class="fas fa-user text-gray-500 text-4xl"></i>
                            @endif
                        </div>
                    </div>
                    <hr class="mb-6">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                        <div>
                            <h3 class="text-sm font-semibold text-gray-500 mb-1">Name</h3>
                            <p class="text-gray-800 text-lg">{{ Auth::user()->name ?? 'N/A' }}</p>
                        </div>
                        
                        <div>
                            <h3 class="text-sm font-semibold text-gray-500 mb-1">Email Address</h3>
                            <p class="text-gray-800 text-lg">{{ Auth::user()->email ?? 'N/A' }}</p>
                        </div>

                        <div>
                            <h3 class="text-sm font-semibold text-gray-500 mb-1">Phone</h3>
                            {{-- FIX: Access profile relation --}}
                            <p class="text-gray-800 text-lg">{{ optional(Auth::user()->profile)->phone_number ?? 'N/A' }}</p>
                        </div>

                        <div>
                            <h3 class="text-sm font-semibold text-gray-500 mb-1">Instagram</h3>
                            {{-- FIX: Access profile relation --}}
                            <p class="text-gray-800 text-lg">{{ optional(Auth::user()->profile)->instagram_url ?? 'N/A' }}</p>
                        </div>

                        <div>
                            <h3 class="text-sm font-semibold text-gray-500 mb-1">TikTok</h3>
                            {{-- FIX: Access profile relation --}}
                            <p class="text-gray-800 text-lg">{{ optional(Auth::user()->profile)->tiktok_url ?? 'N/A' }}</p>
                        </div>
                        
                        <hr class="md:col-span-2">

                        <div>
                            <h3 class="text-sm font-semibold text-gray-500 mb-1">Language</h3>
                            {{-- FIX: Access profile relation --}}
                            <p class="text-gray-800 text-lg capitalize">{{ optional(Auth::user()->profile)->language ?? 'N/A' }}</p>
                        </div>

                        <div>
                            <h3 class="text-sm font-semibold text-gray-500 mb-1">Currency</h3>
                            {{-- FIX: Access profile relation --}}
                            <p class="text-gray-800 text-lg uppercase">{{ optional(Auth::user()->profile)->currency ?? 'N/A' }}</p>
                        </div>
                        
                        <div>
                            <h3 class="text-sm font-semibold text-gray-500 mb-1">Theme</h3>
                            {{-- FIX: Access profile relation --}}
                            <p class="text-gray-800 text-lg capitalize">{{ optional(Auth::user()->profile)->theme ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <h2 class="text-2xl font-bold text-gray-800 mt-10 mb-6">Other Settings</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white rounded-lg shadow-xl p-6">
                    <h3 class="text-xl font-semibold mb-4">Notifications</h3>
                    {{-- FIX: Access settings from User model --}}
                    @php
                        $email_notifications = Auth::user()->settings['notifications']['email'] ?? false;
                        $sms_notifications = Auth::user()->settings['notifications']['sms'] ?? false;
                    @endphp
                    <p class="text-gray-600">Email Notifications: <span class="font-semibold {{ $email_notifications ? 'text-green-600' : 'text-red-600' }}">{{ $email_notifications ? 'On' : 'Off' }}</span></p>
                    <p class="text-gray-600">SMS Notifications: <span class="font-semibold {{ $sms_notifications ? 'text-green-600' : 'text-red-600' }}">{{ $sms_notifications ? 'On' : 'Off' }}</span></p>
                     <a href="{{ route('profile.edit', ['#' => 'notifications']) }}" class="text-purple-600 hover:underline text-sm font-semibold mt-4 inline-block">Edit Notification Settings &rarr;</a>
                </div>
                <div class="bg-white rounded-lg shadow-xl p-6">
                     <h3 class="text-xl font-semibold mb-4">Security</h3>
                     <p class="text-gray-600">Manage your account password.</p>
                     <a href="{{ route('profile.edit', ['#' => 'security']) }}" class="text-purple-600 hover:underline text-sm font-semibold mt-4 inline-block">Change Password &rarr;</a>
                </div>
            </div>
            
        </main>
    </div>
</body>
</html>