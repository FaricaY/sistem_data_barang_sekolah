<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartAssets - Edit Settings</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen"> {{-- FIX: Use min-h-screen for better layout --}}
        <aside class="fixed top-0 left-0 h-screen w-64 bg-purple-600 text-white flex flex-col shadow-2xl z-20">
            <div class="p-6">
                <h1 class="text-2xl font-bold">Smart<span class="text-pink-300">Assets</span></h1>
            </div>

            <div class="flex flex-col items-center bg-purple-700/50 rounded-xl p-4 mx-4 mb-6 shadow-inner">
                <div class="w-16 h-16 rounded-full bg-pink-300 flex items-center justify-center border-2 border-white overflow-hidden">
                    {{-- FIX: Access profile relation --}}
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
            <h1 class="text-3xl font-bold text-gray-800 mb-8">Edit Settings</h1>

            {{-- Display General Status Message --}}
            @if (session('status'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md shadow-sm" role="alert">
                    <p>{{ session('status') }}</p>
                </div>
            @endif

            {{-- Display Validation Errors --}}
            @if ($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md shadow-sm" role="alert">
                    <p class="font-bold">Please fix the following errors:</p>
                    <ul class="mt-2 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white rounded-lg shadow-xl p-6 flex flex-col md:flex-row md:space-x-8">
                <div class="w-full md:w-1/4 border-b md:border-b-0 md:border-r pb-6 md:pb-0 md:pr-8 mb-6 md:mb-0">
                    <nav class="flex flex-row md:flex-col space-x-2 md:space-x-0 md:space-y-2">
                        <button data-tab="general" class="tab-button w-full text-left px-4 py-2 rounded-lg">General</button>
                        <button data-tab="notifications" class="tab-button w-full text-left px-4 py-2 rounded-lg">Notifications</button>
                        <button data-tab="security" class="tab-button w-full text-left px-4 py-2 rounded-lg">Security</button>
                    </nav>
                </div>

                <div class="w-full md:w-3/4">
                    <div id="general-tab" class="tab-content space-y-6">
                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH') {{-- FIX: Use PATCH for updates --}}
                            <h2 class="text-xl font-semibold mb-4">General Profile</h2>
                            <div class="flex items-center mb-6">
                                <div class="w-24 h-24 rounded-full bg-gray-300 mr-6 flex items-center justify-center overflow-hidden">
                                    {{-- FIX: Access profile relation --}}
                                    @if(Auth::user() && optional(Auth::user()->profile)->profile_photo_path)
                                        <img src="{{ asset('storage/' . Auth::user()->profile->profile_photo_path) }}" alt="Profile Picture" class="w-full h-full object-cover">
                                    @else
                                        <i class="fas fa-user text-gray-500 text-4xl"></i>
                                    @endif
                                </div>
                                <div class="flex space-x-2">
                                    {{-- FIX: Add hidden input for photo removal --}}
                                    <input type="hidden" name="remove_profile_photo" id="remove_profile_photo_input" value="0">
                                    <button type="button" onclick="document.getElementById('remove_profile_photo_input').value = '1'; alert('Photo will be removed on save.');" class="text-gray-500 hover:text-red-600 p-2 border rounded-lg transition" title="Delete Photo">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                    <button type="button" onclick="document.getElementById('photoUpload').click();" class="text-gray-500 hover:text-purple-600 p-2 border rounded-lg transition" title="Upload Photo">
                                        <i class="fas fa-upload"></i> Upload
                                    </button>
                                    <input type="file" id="photoUpload" name="profile_photo" class="hidden">
                                </div>
                            </div>
                            <hr class="mb-6">
                            <div class="space-y-6">
                                <div>
                                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Name</label>
                                    <input type="text" id="name" name="name" value="{{ old('name', Auth::user()->name ?? '') }}" class="w-full px-4 py-2 border border-purple-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 transition">
                                </div>
                                <div>
                                    <h3 class="text-sm font-semibold text-gray-700 mb-1">Contacts</h3>
                                    <div class="space-y-2">
                                        {{-- FIX: name="phone_number" and value optional() --}}
                                        <div><input type="tel" id="phone_number" name="phone_number" value="{{ old('phone_number', optional(Auth::user()->profile)->phone_number ?? '') }}" placeholder="Phone Number" class="w-full px-4 py-2 border border-purple-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 transition"></div>
                                        {{-- FIX: email is not on profile, make readonly --}}
                                        <div><input type="email" id="email" name="email" value="{{ Auth::user()->email ?? '' }}" placeholder="Email Address" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 cursor-not-allowed" readonly></div>
                                    </div>
                                </div>
                                <div>
                                    <h3 class="text-sm font-semibold text-gray-700 mb-1">Social Media</h3>
                                     <div class="space-y-2">
                                        {{-- FIX: name="instagram_url" and value optional() --}}
                                        <div><input type="url" id="instagram_url" name="instagram_url" value="{{ old('instagram_url', optional(Auth::user()->profile)->instagram_url ?? '') }}" placeholder="Instagram URL (e.g., https://...)" class="w-full px-4 py-2 border border-purple-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 transition"></div>
                                        {{-- FIX: name="tiktok_url" and value optional() --}}
                                        <div><input type="url" id="tiktok_url" name="tiktok_url" value="{{ old('tiktok_url', optional(Auth::user()->profile)->tiktok_url ?? '') }}" placeholder="TikTok URL (e.g., https://...)" class="w-full px-4 py-2 border border-purple-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 transition"></div>
                                     </div>
                                </div>
                                <hr>
                                <div>
                                    <h3 class="text-sm font-semibold text-gray-700 mb-1">Language & Currency</h3>
                                     <div class="flex space-x-4">
                                        {{-- FIX: value optional() --}}
                                        <select name="language" class="w-1/2 px-4 py-2 border border-purple-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 transition">
                                            <option value="English" {{ old('language', optional(Auth::user()->profile)->language ?? 'English') == 'English' ? 'selected' : '' }}>English</option>
                                            <option value="Indonesian" {{ old('language', optional(Auth::user()->profile)->language ?? 'English') == 'Indonesian' ? 'selected' : '' }}>Bahasa Indonesia</option>
                                        </select>
                                        {{-- FIX: value optional() --}}
                                        <select name="currency" class="w-1/2 px-4 py-2 border border-purple-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 transition">
                                             <option value="USD" {{ old('currency', optional(Auth::user()->profile)->currency ?? 'USD') == 'USD' ? 'selected' : '' }}>USD</option>
                                             <option value="IDR" {{ old('currency', optional(Auth::user()->profile)->currency ?? 'USD') == 'IDR' ? 'selected' : '' }}>IDR</option>
                                        </select>
                                     </div>
                                </div>
                                <div>
                                    <h3 class="text-sm font-semibold text-gray-700 mb-1">Theme</h3>
                                    {{-- FIX: value optional() --}}
                                    <select name="theme" class="w-full px-4 py-2 border border-purple-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 transition">
                                        <option value="Light" {{ old('theme', optional(Auth::user()->profile)->theme ?? 'Light') == 'Light' ? 'selected' : '' }}>Light</option>
                                        <option value="Dark" {{ old('theme', optional(Auth::user()->profile)->theme ?? 'Light') == 'Dark' ? 'selected' : '' }}>Dark</option>
                                    </select>
                                </div>
                                <div class="mt-8 flex justify-end space-x-4">
                                    <a href="{{ route('settings') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 font-semibold hover:bg-gray-100 transition">Cancel</a>
                                    <button type="submit" class="px-6 py-2 bg-purple-500 text-white font-semibold rounded-lg hover:bg-purple-600 transition shadow-md">Save General</f>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div id="notifications-tab" class="tab-content hidden">
                        <form action="{{ route('settings.notifications.update') }}" method="POST">
                            @csrf
                            @method('PATCH') {{-- FIX: Use PATCH --}}
                            <h2 class="text-xl font-semibold mb-4">Notification Settings</h2>
                            <p class="text-gray-600 mb-6">Configure how you receive notifications.</p>
                            @php
                                // FIX: Get settings from the User model's 'settings' array
                                $email_notifications = Auth::user()->settings['notifications']['email'] ?? false;
                                $sms_notifications = Auth::user()->settings['notifications']['sms'] ?? false;
                            @endphp
                            <div class="space-y-4">
                                 <div class="flex items-center">
                                    {{-- FIX: Name and checked status --}}
                                    <input type="hidden" name="email_notifications" value="0">
                                    <input id="email_notifications" name="email_notifications" type="checkbox" value="1" {{ old('email_notifications', $email_notifications) ? 'checked' : '' }} class="h-4 w-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                                    <label for="email_notifications" class="ml-3 block text-sm font-medium text-gray-700">Receive email notifications</label>
                                 </div>
                                 <div class="flex items-center">
                                    {{-- FIX: Name and checked status --}}
                                    <input type="hidden" name="sms_notifications" value="0">
                                    <input id="sms_notifications" name="sms_notifications" type="checkbox" value="1" {{ old('sms_notifications', $sms_notifications) ? 'checked' : '' }} class="h-4 w-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                                    <label for="sms_notifications" class="ml-3 block text-sm font-medium text-gray-700">Receive SMS alerts (requires phone number)</label>
                                 </div>
                            </div>
                            <div class="mt-8 flex justify-end space-x-4">
                                <a href="{{ route('settings') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 font-semibold hover:bg-gray-100 transition">Cancel</a>
                                <button type="submit" class="px-6 py-2 bg-purple-500 text-white font-semibold rounded-lg hover:bg-purple-600 transition shadow-md">Save Notifications</button>
                            </div>
                        </form>
                    </div>

                    <div id="security-tab" class="tab-content hidden">
                        <form action="{{ route('settings.security.update') }}" method="POST">
                             @csrf
                             @method('PATCH') {{-- FIX: Use PATCH --}}
                            <h2 class="text-xl font-semibold mb-4">Security Settings</h2>
                            <p class="text-gray-600 mb-6">Update your password.</p>
                            <div class="space-y-4">
                                 <div>
                                     <label for="current_password" class="block text-sm font-semibold text-gray-700 mb-1">Current Password</label>
                                     <input type="password" id="current_password" name="current_password" class="w-full px-4 py-2 border border-purple-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 transition" required>
                                 </div>
                                  <div>
                                     <label for="new_password" class="block text-sm font-semibold text-gray-700 mb-1">New Password</label>
                                     <input type="password" id="new_password" name="new_password" class="w-full px-4 py-2 border border-purple-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 transition" required>
                                 </div>
                                  <div>
                                     <label for="new_password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1">Confirm New Password</label>
                                     <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="w-full px-4 py-2 border border-purple-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 transition" required>
                                 </div>
                            </div>
                            <div class="mt-8 flex justify-end space-x-4">
                                <a href="{{ route('settings') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 font-semibold hover:bg-gray-100 transition">Cancel</a>
                                <button type="submit" class="px-6 py-2 bg-purple-500 text-white font-semibold rounded-lg hover:bg-purple-600 transition shadow-md">Update Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>

    {{-- Script for tab functionality --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tabButtons = document.querySelectorAll('.tab-button');
            const tabContents = document.querySelectorAll('.tab-content');

            function switchTab(tab) {
                // Update button styles
                tabButtons.forEach(btn => {
                    if (btn.getAttribute('data-tab') === tab) {
                        btn.classList.add('bg-gray-100', 'text-purple-600', 'font-semibold');
                        btn.classList.remove('text-gray-600', 'hover:bg-gray-50', 'hover:text-purple-600');
                    } else {
                        btn.classList.remove('bg-gray-100', 'text-purple-600', 'font-semibold');
                        btn.classList.add('text-gray-600', 'hover:bg-gray-50', 'hover:text-purple-600');
                    }
                });

                // Show the correct content
                tabContents.forEach(content => {
                    if (content.id === `${tab}-tab`) {
                        content.classList.remove('hidden');
                    } else {
                        content.classList.add('hidden');
                    }
                });
            }

            tabButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const tab = button.getAttribute('data-tab');
                    // Update URL hash without jumping
                    history.pushState(null, null, `#${tab}`);
                    switchTab(tab);
                });
            });

            // Pre-select tab based on URL hash or default to 'general'
            const initialTab = window.location.hash.substring(1) || 'general';
            switchTab(initialTab);

            // Listen for hash changes (e.g., back/forward buttons)
            window.addEventListener('hashchange', () => {
                const tab = window.location.hash.substring(1) || 'general';
                switchTab(tab);
            });
        });
    </script>
</body>
</html>