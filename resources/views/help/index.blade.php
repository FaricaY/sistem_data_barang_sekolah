<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartAssets - Help</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }
        .faq-question.active + .faq-answer {
            max-height: 500px; /* Adjust as needed */
            transition: max-height 0.5s ease-in;
        }
        .faq-question .fa-chevron-down {
             transition: transform 0.3s ease-out;
        }
        .faq-question.active .fa-chevron-down {
            transform: rotate(180deg);
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

        <!-- Main Content -->
        <main class="ml-64 p-8 w-full">
            {{-- Help Page Content Starts --}}
            <div class="flex justify-end space-x-6 mb-8 text-gray-700 font-semibold">
                <a href="#" class="hover:text-purple-600">Home</a>
                <a href="#" class="hover:text-purple-600">Contact Support</a>
            </div>

            <div class="text-center mb-10">
                <h1 class="text-4xl font-bold text-gray-800 mb-2">How can we help you?</h1>
                <p class="text-gray-600">Find answers and guide for using SmartAssets.</p>
            </div>

            <div class="relative w-full max-w-2xl mx-auto mb-10">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input type="text" placeholder="Search" class="w-full pl-12 pr-4 py-3 border-2 border-purple-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 transition shadow-sm">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
                <div class="bg-white p-6 rounded-lg border border-purple-200 shadow-sm hover:shadow-md transition cursor-pointer">
                    <h3 class="font-bold text-lg text-gray-800 mb-1">Inventory Management</h3>
                    <p class="text-sm text-gray-600">Track and update your school supply stock</p>
                </div>
                 <div class="bg-white p-6 rounded-lg border border-purple-200 shadow-sm hover:shadow-md transition cursor-pointer">
                    <h3 class="font-bold text-lg text-gray-800 mb-1">School Setup</h3>
                    <p class="text-sm text-gray-600">Manage classrooms, departments, and asset categories</p>
                </div>
                 <div class="bg-white p-6 rounded-lg border border-purple-200 shadow-sm hover:shadow-md transition cursor-pointer">
                    <h3 class="font-bold text-lg text-gray-800 mb-1">User Account</h3>
                    <p class="text-sm text-gray-600">Add teachers, students, and admins</p>
                </div>
                 <div class="bg-white p-6 rounded-lg border border-purple-200 shadow-sm hover:shadow-md transition cursor-pointer">
                    <h3 class="font-bold text-lg text-gray-800 mb-1">Technical Issue</h3>
                    <p class="text-sm text-gray-600">Troubleshoot login or syncing problems</p>
                </div>
            </div>

            <h2 class="text-2xl font-bold text-gray-800 mb-6">Popular Questions</h2>
            <div class="space-y-4">
                {{-- FAQ Item 1 --}}
                <div class="bg-white rounded-lg border border-purple-200 overflow-hidden shadow-sm">
                    <button class="faq-question w-full flex justify-between items-center p-4 text-left font-semibold text-gray-700 hover:bg-purple-50 transition">
                        <span>How do I add new asset?</span>
                        <i class="fas fa-chevron-down text-purple-500"></i>
                    </button>
                    <div class="faq-answer px-4 pb-4 text-gray-600">
                        <p>To add a new asset, go to the inventory tab and click "Add Asset". Fill in the details and save.</p>
                    </div>
                </div>
                {{-- FAQ Item 2 --}}
                 <div class="bg-white rounded-lg border border-purple-200 overflow-hidden shadow-sm">
                    <button class="faq-question w-full flex justify-between items-center p-4 text-left font-semibold text-gray-700 hover:bg-purple-50 transition">
                        <span>Why is my inventory count incorrect?</span>
                        <i class="fas fa-chevron-down text-purple-500"></i>
                    </button>
                    <div class="faq-answer px-4 pb-4 text-gray-600">
                        <p>Inventory counts can become incorrect due to manual entry errors, untracked usage, or theft. Ensure all item movements are recorded promptly. Regular audits can help identify discrepancies.</p>
                    </div>
                </div>
                 {{-- FAQ Item 3 --}}
                 <div class="bg-white rounded-lg border border-purple-200 overflow-hidden shadow-sm">
                    <button class="faq-question w-full flex justify-between items-center p-4 text-left font-semibold text-gray-700 hover:bg-purple-50 transition">
                        <span>How do I generate a usage report?</span>
                        <i class="fas fa-chevron-down text-purple-500"></i>
                    </button>
                    <div class="faq-answer px-4 pb-4 text-gray-600">
                        <p>Usage reports can typically be generated from the reporting section of the application. Look for options related to item history or transaction logs. You may be able to filter by date range, item type, or location.</p>
                    </div>
                </div>
                {{-- Add more FAQ items as needed --}}
            </div>
            {{-- Help Page Content Ends --}}
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const faqQuestions = document.querySelectorAll('.faq-question');

            faqQuestions.forEach(button => {
                button.addEventListener('click', () => {
                    // Toggle the 'active' class on the button
                    button.classList.toggle('active');
                    
                    // The answer is the next sibling element
                    const answer = button.nextElementSibling; 
                    
                    // Expand or collapse the answer
                    if (button.classList.contains('active')) {
                        answer.style.maxHeight = answer.scrollHeight + "px"; // Expand to fit content
                    } else {
                        answer.style.maxHeight = '0'; // Collapse
                    }
                });
            });
        });
    </script>
</body>
</html>