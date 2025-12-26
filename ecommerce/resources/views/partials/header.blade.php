<header class="bg-white shadow">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
        <a href="/" class="text-xl font-bold text-indigo-600">MyShop</a>

        <nav class="space-x-4">
            @auth
                <a href="/dashboard" class="text-gray-700 hover:text-indigo-600">
                    Dashboard
                </a>
            @else
                <a href="/login" class="text-gray-700 hover:text-indigo-600">
                    Login
                </a>
                <a href="/register" class="text-gray-700 hover:text-indigo-600">
                    Register
                </a>
            @endauth
        </nav>
    </div>
</header>
