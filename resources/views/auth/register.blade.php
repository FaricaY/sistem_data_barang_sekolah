<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white rounded-2xl shadow-lg flex w-3/4 max-w-5xl overflow-hidden">
        
<!-- Left Image -->
<div class="hidden md:block w-1/2 bg-purple-50">
<img src="https://www.officefurnitures.ca/assets/default/img/login-img.png" 
     alt="Register Illustration" 
     class="w-full h-full object-cover">

</div>

        <!-- Right Form -->
        <div class="w-full md:w-1/2 p-10 flex flex-col justify-center">
            <h2 class="text-3xl font-bold text-purple-600 mb-6">Welcome to SmartAssets</h2>

            <form action="{{ route('register.post') }}" method="POST" class="space-y-5">
                @csrf

                <!-- First + Last Name (side by side) -->
                <div class="flex space-x-4">
                    <div class="w-1/2">
                        <label class="block mb-1 text-gray-700">First name</label>
                        <input type="text" name="first_name" placeholder="Enter your first name"
                            class="w-full px-4 py-2 border border-purple-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    <div class="w-1/2">
                        <label class="block mb-1 text-gray-700">Last name</label>
                        <input type="text" name="last_name" placeholder="Enter your last name"
                            class="w-full px-4 py-2 border border-purple-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                </div>

                <!-- Username -->
                <div>
                    <label class="block mb-1 text-gray-700">Username</label>
                    <input type="text" name="username" placeholder="Enter your username"
                        class="w-full px-4 py-2 border border-purple-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>

                <!-- Email -->
                <div>
                    <label class="block mb-1 text-gray-700">Email</label>
                    <input type="email" name="email" placeholder="Enter your email"
                        class="w-full px-4 py-2 border border-purple-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>

                <!-- Password -->
                <div>
                    <label class="block mb-1 text-gray-700">Password</label>
                    <input type="password" name="password" placeholder="Enter your password"
                        class="w-full px-4 py-2 border border-purple-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>

                <!-- Confirm Password -->
                <div>
                    <label class="block mb-1 text-gray-700">Confirm password</label>
                    <input type="password" name="password_confirmation" placeholder="Enter your password"
                        class="w-full px-4 py-2 border border-purple-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>

                <!-- Remember me & Forgot password -->
                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="remember" class="rounded text-purple-600">
                        <span>Remember me</span>
                    </label>
                    <a href="#" class="text-purple-600 hover:underline">Forgot password?</a>
                </div>

                <!-- Register Button -->
                <button type="submit" 
                        class="w-full bg-purple-600 text-white py-2 rounded-lg hover:bg-purple-700 transition">
                    Register
                </button>
            </form>

            <p class="mt-6 text-gray-600 text-sm text-center">
                Already have an account? 
                <a href="{{ route('login') }}" class="text-blue-500 hover:underline">Click here</a>
            </p>
        </div>
    </div>

    <!-- SweetAlert2 Popups -->
    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Registration Failed',
                text: '{{ $errors->first() }}',
                confirmButtonColor: '#9333ea'
            })
        </script>
    @endif
</body>
</html>
