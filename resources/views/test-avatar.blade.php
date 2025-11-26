<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avatar Test Page</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold mb-8 text-gray-800">Default Avatar Implementation Test</h1>
        
        <!-- Avatar Size Variants -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-xl font-semibold mb-4">Avatar Size Variants</h2>
            <div class="flex items-center gap-6 flex-wrap">
                <div class="text-center">
                    <div class="avatar avatar-sm mb-2">
                        <img src="{{ asset('images/default-avatar.svg') }}" alt="Small Avatar" class="avatar-image">
                    </div>
                    <p class="text-sm text-gray-600">Small (32px)</p>
                </div>
                <div class="text-center">
                    <div class="avatar avatar-md mb-2">
                        <img src="{{ asset('images/default-avatar.svg') }}" alt="Medium Avatar" class="avatar-image">
                    </div>
                    <p class="text-sm text-gray-600">Medium (40px)</p>
                </div>
                <div class="text-center">
                    <div class="avatar avatar-lg mb-2">
                        <img src="{{ asset('images/default-avatar.svg') }}" alt="Large Avatar" class="avatar-image">
                    </div>
                    <p class="text-sm text-gray-600">Large (48px)</p>
                </div>
                <div class="text-center">
                    <div class="avatar avatar-xl mb-2">
                        <img src="{{ asset('images/default-avatar.svg') }}" alt="Extra Large Avatar" class="avatar-image">
                    </div>
                    <p class="text-sm text-gray-600">XL (64px)</p>
                </div>
                <div class="text-center">
                    <div class="avatar avatar-2xl mb-2">
                        <img src="{{ asset('images/default-avatar.svg') }}" alt="2XL Avatar" class="avatar-image">
                    </div>
                    <p class="text-sm text-gray-600">2XL (80px)</p>
                </div>
            </div>
        </div>

        <!-- Avatar Fallback Scenarios -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-xl font-semibold mb-4">Avatar Fallback Scenarios</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Working Avatar -->
                <div class="text-center">
                    <div class="avatar avatar-xl mb-3 mx-auto">
                        <img src="{{ asset('images/default-avatar.svg') }}" alt="Default Avatar" class="avatar-image">
                    </div>
                    <h3 class="font-medium">Default Avatar SVG</h3>
                    <p class="text-sm text-gray-600">New default avatar implementation</p>
                </div>

                <!-- Broken Image Fallback -->
                <div class="text-center">
                    <div class="avatar avatar-xl mb-3 mx-auto">
                        <img src="/nonexistent-image.jpg" alt="Broken Image" class="avatar-image" 
                             onerror="this.src='{{ asset('images/default-avatar.svg') }}'">
                    </div>
                    <h3 class="font-medium">Broken Image Fallback</h3>
                    <p class="text-sm text-gray-600">Should fallback to default avatar</p>
                </div>

                <!-- Initials Fallback -->
                <div class="text-center">
                    <div class="avatar avatar-xl mb-3 mx-auto">
                        <div class="avatar-fallback">
                            <span class="text-lg font-semibold">JD</span>
                        </div>
                    </div>
                    <h3 class="font-medium">Initials Fallback</h3>
                    <p class="text-sm text-gray-600">Traditional initials approach</p>
                </div>
            </div>
        </div>

        <!-- User List Simulation -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-xl font-semibold mb-4">User List Simulation</h2>
            <div class="space-y-4">
                <div class="flex items-center gap-4 p-3 border rounded-lg">
                    <div class="avatar avatar-md">
                        <img src="{{ asset('images/default-avatar.svg') }}" alt="User Avatar" class="avatar-image">
                    </div>
                    <div>
                        <h3 class="font-medium">Maria Rodriguez</h3>
                        <p class="text-sm text-gray-600">Fotograaf • Willemstad</p>
                    </div>
                </div>
                <div class="flex items-center gap-4 p-3 border rounded-lg">
                    <div class="avatar avatar-md">
                        <img src="{{ asset('images/default-avatar.svg') }}" alt="User Avatar" class="avatar-image">
                    </div>
                    <div>
                        <h3 class="font-medium">Carlos Martina</h3>
                        <p class="text-sm text-gray-600">Muzikant • Punda</p>
                    </div>
                </div>
                <div class="flex items-center gap-4 p-3 border rounded-lg">
                    <div class="avatar avatar-md">
                        <img src="{{ asset('images/default-avatar.svg') }}" alt="User Avatar" class="avatar-image">
                    </div>
                    <div>
                        <h3 class="font-medium">Isabella Santos</h3>
                        <p class="text-sm text-gray-600">Designer • Otrobanda</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dark Mode Test -->
        <div class="bg-gray-900 text-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-xl font-semibold mb-4">Dark Mode Compatibility</h2>
            <div class="flex items-center gap-6">
                <div class="avatar avatar-lg">
                    <img src="{{ asset('images/default-avatar.svg') }}" alt="Dark Mode Avatar" class="avatar-image">
                </div>
                <div>
                    <h3 class="font-medium">Default Avatar in Dark Mode</h3>
                    <p class="text-sm text-gray-300">Should maintain proper contrast and visibility</p>
                </div>
            </div>
        </div>

        <!-- Responsive Test -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">Responsive Behavior</h2>
            <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 gap-4">
                @for ($i = 1; $i <= 12; $i++)
                    <div class="text-center">
                        <div class="avatar avatar-md mb-2 mx-auto">
                            <img src="{{ asset('images/default-avatar.svg') }}" alt="User {{ $i }}" class="avatar-image">
                        </div>
                        <p class="text-xs text-gray-600">User {{ $i }}</p>
                    </div>
                @endfor
            </div>
        </div>
    </div>
</body>
</html>