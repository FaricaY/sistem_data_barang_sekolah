<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartAssets - Log Out</title>
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
                    @if(Auth::user() && Auth::user()->profile_photo_path)
                         <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" alt="User Photo" class="w-full h-full object-cover">
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
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 p-3 rounded-xl transition duration-200 hover:bg-white hover:text-purple-600">
                    <i class="fas fa-th-large w-5"></i><span>Dashboard</span>
                </a>
                <a href="{{ route('items.index') }}" class="flex items-center space-x-3 p-3 rounded-xl transition duration-200 hover:bg-white hover:text-purple-600">
                    <i class="fas fa-database w-5"></i><span>Data</span>
                </a>
                <a href="{{ route('categories.index') }}" class="flex items-center space-x-3 p-3 rounded-xl transition duration-200 hover:bg-white hover:text-purple-600">
                    <i class="fas fa-th-list w-5"></i><span>Categories</span>
                </a>
                <a href="{{ route('condition.index') }}" class="flex items-center space-x-3 p-3 rounded-xl transition duration-200 hover:bg-white hover:text-purple-600">
                    <i class="fas fa-tools w-5"></i><span>Item Condition</span>
                </a>
                <a href="{{ route('settings') }}" class="flex items-center space-x-3 p-3 rounded-xl transition duration-200 hover:bg-white hover:text-purple-600">
                    <i class="fas fa-cog w-5"></i><span>Settings</span>
                </a>
                <a href="{{ route('help.index') }}" class="flex items-center space-x-3 p-3 rounded-xl transition duration-200 hover:bg-white hover:text-purple-600">
                    <i class="fas fa-question-circle w-5"></i><span>Help</span>
                </a>
            </nav>

            <div class="p-4">
                {{-- This link is now highlighted as active --}}
                <a href="{{ route('logout.confirm') }}" class="flex items-center space-x-3 w-full p-3 rounded-xl bg-white text-purple-600 font-bold shadow-md justify-center">
                    <i class="fas fa-sign-out-alt"></i><span>Log out</span>
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="ml-64 p-8 w-full">
            <div class="w-full h-full flex items-center justify-center">
                <div class="bg-white p-10 rounded-2xl shadow-xl max-w-lg text-center border-2 border-purple-200">
                    <i class="fas fa-door-open text-purple-500 text-6xl mb-6"></i>
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Are you sure want to log out?</h1>
                    <p class="text-gray-600 mb-8">You'll be signed out of your SmartAssets account.</p>
                    
                    <div class="flex justify-center space-x-4">
                        <!-- Cancel Button: Goes back to the dashboard -->
                        <a href="{{ route('dashboard') }}" class="px-8 py-3 rounded-xl border border-gray-300 text-gray-700 font-semibold hover:bg-gray-100 transition">
                            Cancel
                        </a>
                        
                        <!-- Log Out Button: Submits the actual logout form -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="px-8 py-3 rounded-xl bg-purple-500 text-white font-semibold hover:bg-purple-600 transition shadow-md">
                                Log out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
```

### 4. Update Your Sidebar Link (On All Pages)

Finally, you must change the "Log out" button on **all your other pages** (like `dashboard.blade.php`, `items/index.blade.php`, etc.) so they *link* to this new confirmation page instead of logging out instantly.

**Find this old code in your sidebars:**
```html
<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" class="flex items-center space-x-3 w-full p-3 rounded-xl text-white bg-purple-700 hover:bg-pink-300 hover:text-purple-900 transition font-semibold shadow-lg justify-center">
        <i class="fas fa-sign-out-alt"></i><span>Log out</span>
    </button>
</form>
```

**And REPLACE it with this new code (which is a simple link):**
```html
<a href="{{ route('logout.confirm') }}" class="flex items-center space-x-3 w-full p-3 rounded-xl text-white hover:bg-pink-300 hover:text-purple-900 transition font-semibold justify-center">
    <i class="fas fa-sign-out-alt"></i><span>Log out</span>
</a>