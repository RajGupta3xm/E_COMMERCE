{{-- resources/views/layouts/admin.blade.php --}}
<!DOCTYPE html>
<html lang="en" x-data="{ sidebarOpen: window.innerWidth >= 1024 }">
<head>
    <!-- ... other meta tags ... -->
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- OR Bootstrap if you prefer -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Your custom CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-gray-50 font-sans">
    <!-- Navbar -->
    @include('admin.partials.navbar')
    
    <!-- Sidebar -->
    @include('admin.partials.sidebar')
    
    <!-- Main Content -->
    <main class="lg:pl-64 pt-16 min-h-screen">
        <div class="p-6">
            <!-- Page Header -->
            <div class="mb-6">
                @yield('header')
            </div>
            
            <!-- Content -->
            <div class="space-y-6">
                @yield('content')
            </div>
        </div>
    </main>

    <!-- Scripts -->
    <script>
        // Toggle sidebar on mobile
        function toggleSidebar() {
            const sidebar = document.querySelector('[x-data]');
            sidebar.__x.getUnobservedData().sidebarOpen = !sidebar.__x.getUnobservedData().sidebarOpen;
        }
    </script>
    
    @stack('scripts')
</body>
</html>