<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Heroicons for eye icon -->
    <script src="https://unpkg.com/feather-icons"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white rounded-2xl shadow-lg flex w-4/5 max-w-5xl overflow-hidden">

<!-- Left Image -->
<div class="hidden md:block w-1/2 bg-purple-50">
<img src="https://www.officefurnitures.ca/assets/default/img/login-img.png" 
     alt="Register Illustration" 
     class="w-full h-full object-cover">

</div>

        <!-- Right Form -->
        <div class="w-1/2 p-12 flex flex-col justify-center">
            <h2 class="text-3xl font-bold text-purple-600 mb-8 leading-snug">
                Hello,<br>Welcome Back
            </h2>

            <form action="{{ route('login.post') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Username or Email -->
                <div>
                    <label class="block mb-1 text-gray-700 font-medium">Username or Email</label>
                    <input type="text" name="email" placeholder="Enter your username or email"
                        class="w-full px-4 py-3 border border-purple-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>

                <!-- Password -->
                <div>
                    <label class="block mb-1 text-gray-700 font-medium">Password</label>
                    <div class="relative">
                        <input type="password" name="password" id="password" placeholder="Enter your password"
                            class="w-full px-4 py-3 border border-purple-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                        <span onclick="togglePassword()" class="absolute right-4 top-3 cursor-pointer text-gray-500">
                            <i data-feather="eye"></i>
                        </span>
                    </div>
                </div>

                <!-- Remember me + Forgot password -->
                <div class="flex justify-between items-center text-sm">
                    <label class="inline-flex items-center">
                        <input type="checkbox" class="form-checkbox text-purple-600">
                        <span class="ml-2 text-gray-600">Remember me</span>
                    </label>
                    <a href="#" class="text-purple-600 hover:underline">Forgot password?</a>
                </div>

                <!-- Login Button -->
                <button type="submit" 
                        class="w-full bg-purple-600 text-white py-3 rounded-lg hover:bg-purple-700 transition">
                    Login
                </button>
            </form>

            <!-- Register link -->
            <p class="mt-8 text-gray-600 text-sm text-center">
                Don’t have an account? 
                <a href="{{ route('register') }}" class="text-blue-500 hover:underline">Click here</a>
            </p>
        </div>
    </div>

    <!-- SweetAlert2 Popups -->
    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Login Failed',
                text: '{{ $errors->first() }}',
                confirmButtonColor: '#9333ea'
            })
        </script>
    @endif

    <script>
        feather.replace();

        function togglePassword() {
            const pass = document.getElementById('password');
            pass.type = pass.type === "password" ? "text" : "password";
        }
    </script>
</body>
</html>
