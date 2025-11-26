@extends('layouts.landing')

@section('title', 'Login - Curaçao Talents')

@section('content')
    <div class="min-h-screen flex items-center justify-center p-6"
        style="background: linear-gradient(135deg, #6A0AFC 0%, #B535FF 100%);">
        <!-- Background shapes -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-20 left-20 w-32 h-40 rounded-2xl transform rotate-12"
                style="background: linear-gradient(135deg, rgba(106, 10, 252, 0.6) 0%, rgba(181, 53, 255, 0.6) 100%);"></div>
            <div class="absolute top-40 right-32 w-24 h-24 rounded-full"
                style="background: linear-gradient(135deg, rgba(106, 10, 252, 0.6) 0%, rgba(181, 53, 255, 0.6) 100%);"></div>
            <div class="absolute bottom-32 left-40 w-20 h-28 rounded-xl transform -rotate-12"
                style="background: linear-gradient(135deg, rgba(181, 53, 255, 0.6) 0%, rgba(106, 10, 252, 0.6) 100%);"></div>
        </div>

        <div class="w-full max-w-md bg-white/95 backdrop-blur-sm shadow-2xl relative z-10 rounded-lg border border-border">
            <div class="p-6 border-b border-border text-center">
                <div class="w-16 h-16 mx-auto mb-4">
                    <img src="{{ asset('images/brug-logo.png') }}" alt="Brug Kreativo" class="w-full h-full object-contain">
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Login to Curaçao Talents</h2>
                <p class="text-gray-600">Choose your account type and sign in</p>
            </div>

            <div class="p-6 space-y-6">
                <!-- Success Message -->
                @if (session('status'))
                    <div class="rounded-md bg-green-50 p-4 border border-green-200">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i data-lucide="check-circle" class="h-5 w-5 text-green-400"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-green-800">
                                    {{ session('status') }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- General Error Messages -->
                @if ($errors->any() && !$errors->has('email') && !$errors->has('password'))
                    <div class="rounded-md bg-red-50 p-4 border border-red-200">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i data-lucide="alert-circle" class="h-5 w-5 text-red-400"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">
                                    Login failed
                                </h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <ul class="list-disc pl-5 space-y-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf

                    <!-- Email -->
                    <div class="space-y-2">
                        <label for="email"
                            class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Email</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}"
                            placeholder="Enter your email" required autofocus autocomplete="username"
                            class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 @error('email') border-red-500 @enderror" />
                        @error('email')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="space-y-2">
                        <label for="password"
                            class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Password</label>
                        <div class="relative">
                            <input id="password" name="password" type="password" placeholder="Enter your password" required
                                autocomplete="current-password"
                                class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 pr-10 @error('password') border-red-500 @enderror" />
                            <button type="button" onclick="togglePassword()"
                                class="absolute right-0 top-0 h-full px-3 py-2 hover:bg-transparent text-gray-500 hover:text-gray-700">
                                <i data-lucide="eye" id="eye-icon" class="h-4 w-4"></i>
                                <i data-lucide="eye-off" id="eye-off-icon" class="h-4 w-4 hidden"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center space-x-2">
                        <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}
                            class="peer h-4 w-4 shrink-0 rounded-sm border border-primary ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" />
                        <label for="remember"
                            class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
                            Remember me
                        </label>
                    </div>

                    @if ($errors->any())
                        <div class="p-4 border border-red-200 bg-red-50 rounded-md">
                            <div class="flex">
                                <i data-lucide="alert-circle" class="w-5 h-5 text-red-400 mr-3 mt-0.5"></i>
                                <div class="text-sm text-red-800">
                                    @foreach ($errors->all() as $error)
                                        <p>{{ $error }}</p>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    @if (session('status'))
                        <div class="p-4 border border-green-200 bg-green-50 rounded-md">
                            <div class="flex">
                                <i data-lucide="check-circle" class="w-5 h-5 text-green-400 mr-3 mt-0.5"></i>
                                <p class="text-sm text-green-800">{{ session('status') }}</p>
                            </div>
                        </div>
                    @endif

                    <button type="submit"
                        class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 text-white h-10 px-4 py-2 w-full"
                        style="background: linear-gradient(135deg, #6A0AFC 0%, #B535FF 100%);"
                        onmouseover="this.style.background='#6A0AFC'"
                        onmouseout="this.style.background='linear-gradient(135deg, #6A0AFC 0%, #B535FF 100%)'">
                        Sign In
                    </button>
                </form>

                <!-- Demo Credentials -->
                {{-- <div class="border-t pt-6">
          <p class="text-sm text-gray-600 mb-4 text-center">Demo Credentials:</p>
          <div class="space-y-2">
            <button type="button" onclick="fillCredentials('admin@gmail.com', 'password')"
              class="inline-flex items-center justify-start gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-9 px-4 py-2 w-full">
              <i data-lucide="shield" class="w-4 h-4 mr-2"></i>
              Admin: admin@gmail.com / password
            </button>
            <button type="button" onclick="fillCredentials('explosion-dancer1@curacao-talents.com', 'password')"
              class="inline-flex items-center justify-start gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-9 px-4 py-2 w-full">
              <i data-lucide="camera" class="w-4 h-4 mr-2"></i>
              Creator: explosion-dancer1@curacao-talents.com / password
            </button>
            <button type="button" onclick="fillCredentials('jennifer.smith@member.com', 'password')"
              class="inline-flex items-center justify-start gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-9 px-4 py-2 w-full">
              <i data-lucide="user" class="w-4 h-4 mr-2"></i>
              User: jennifer.smith@member.com / password
            </button>
          </div>
        </div> --}}

                <!-- Additional Links -->
                <div class="space-y-4">
                    @if (Route::has('password.request'))
                        <div class="text-center">
                            <a href="{{ route('password.request') }}"
                                class="text-sm text-gray-600 hover:text-pink-600 transition-colors">
                                Forgot your password?
                            </a>
                        </div>
                    @endif

                    @if (Route::has('register'))
                        <div class="text-center">
                            <p class="text-sm text-gray-600">New to our platform?</p>
                            <a href="{{ route('register') }}"
                                class="text-sm text-pink-600 hover:text-pink-700 font-medium transition-colors">
                                Create an account
                            </a>
                        </div>
                    @endif

                    <div class="text-center">
                        <a href="/" class="text-sm text-gray-600 hover:text-pink-600 transition-colors">
                            Back to Homepage
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            const eyeOffIcon = document.getElementById('eye-off-icon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.add('hidden');
                eyeOffIcon.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('hidden');
                eyeOffIcon.classList.add('hidden');
            }
        }

        function fillCredentials(email, password) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = password;
        }

        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('[class*="border-red-"], [class*="border-green-"]');
            alerts.forEach(function(alert) {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(function() {
                    alert.remove();
                }, 500);
            });
        }, 5000);
    </script>
@endsection
