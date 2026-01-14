{{-- resources/views/layouts/admin.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>

    {{-- ONLY VITE (no CDN, no bootstrap) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script>
    window.Laravel = {
        baseUrl: '{{ url("/") }}',
        apiUrl: '{{ url("/api") }}'
    };
</script>
    
 <script src="https://cdn.tailwindcss.com"></script>
    
    
    <!-- OR Bootstrap if you prefer -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body class="bg-gray-50 font-sans">

<div x-data="{ sidebarOpen: false }"
     x-init="
        if (window.innerWidth >= 1024) sidebarOpen = true;
        window.addEventListener('resize', () => {
            sidebarOpen = window.innerWidth >= 1024
        });
     ">

    <!-- Navbar -->
    @include('admin.partials.navbar')

    <!-- Sidebar -->
    @include('admin.partials.sidebar')

    <!-- Main Content -->
    <main class="lg:pl-64 pt-16 min-h-screen">
        <div class="p-6">
            <div class="mb-6">
                @yield('header')
            </div>

            <div class="space-y-6">
                @yield('content')
            </div>
        </div>
    </main>

</div>

@stack('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Toast Configuration
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    // Success Message
    @if(session('success'))
        Toast.fire({
            icon: 'success',
            title: "{{ session('success') }}"
        });
    @endif

    // Error Message
    @if(session('error'))
        Toast.fire({
            icon: 'error',
            title: "{{ session('error') }}"
        });
    @endif
    
    // Validation Errors (Laravel $errors)
    @if($errors->any())
        Toast.fire({
            icon: 'error',
            title: "Validation Error!",
            text: "{{ $errors->first() }}"
        });
    @endif
</script>
</body>
</html>
