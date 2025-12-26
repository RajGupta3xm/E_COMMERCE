<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#fef3f2',
                            100: '#ffe4e2',
                            500: '#f97316',
                            600: '#ea580c',
                            700: '#c2410c',
                            800: '#9a3412',
                            900: '#7c2d12',
                        }
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-in-out',
                        'slide-in': 'slideIn 0.3s ease-out',
                        'slide-up': 'slideUp 0.3s ease-out',
                        'bounce-slow': 'bounce 2s infinite',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' }
                        },
                        slideIn: {
                            '0%': { transform: 'translateX(-100%)' },
                            '100%': { transform: 'translateX(0)' }
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(20px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' }
                        }
                    }
                }
            }
        }
    </script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
            overflow-x: hidden;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Sidebar Animations */
        .sidebar-collapsed {
            width: 5rem !important;
        }
        
        .sidebar-collapsed .nav-text,
        .sidebar-collapsed .badge-count,
        .sidebar-collapsed .section-title,
        .sidebar-collapsed .user-info,
        .sidebar-collapsed .sidebar-footer,
        .sidebar-collapsed .logo-text {
            display: none !important;
        }

        .sidebar-expanded {
            width: 16rem !important;
        }

        /* Smooth Transitions */
        .transition-all {
            transition-property: all;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 300ms;
        }

        /* Glass Effect */
        .glass-effect {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        /* Card Hover Effects */
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        /* Active Link Indicator */
        .active-nav-item {
            position: relative;
        }

        .active-nav-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 60%;
            background-color: #f97316;
            border-radius: 0 4px 4px 0;
        }

        /* Table Row Hover */
        .table-row-hover:hover {
            background-color: #f8fafc;
        }

        /* Loading Animation */
        .loading-dots {
            display: inline-flex;
            align-items: center;
        }
        
        .loading-dots span {
            animation: loading 1.4s infinite both;
            background-color: #f97316;
            border-radius: 50%;
            height: 8px;
            width: 8px;
            margin: 0 2px;
        }
        
        .loading-dots span:nth-child(1) {
            animation-delay: -0.32s;
        }
        
        .loading-dots span:nth-child(2) {
            animation-delay: -0.16s;
        }
        
        @keyframes loading {
            0%, 80%, 100% {
                opacity: 0;
                transform: scale(0.5);
            }
            40% {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* Responsive Improvements */
        @media (max-width: 768px) {
            .mobile-menu-open {
                transform: translateX(0);
                box-shadow: 8px 0 25px rgba(0, 0, 0, 0.1);
            }
            
            .mobile-menu-closed {
                transform: translateX(-100%);
            }
        }

        /* Dark Mode Support */
        .dark .dark\:bg-gray-900 {
            background-color: #0f172a;
        }
        
        .dark .dark\:text-gray-100 {
            color: #f1f5f9;
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gray-50 font-sans antialiased">
    <div class="flex h-screen overflow-hidden">
        <!-- Mobile Sidebar Overlay -->
        <div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden md:hidden transition-opacity duration-300"></div>
        
        <!-- Sidebar -->
        <aside id="sidebar" class="fixed md:relative h-full z-40 flex flex-col bg-gradient-to-b from-gray-900 via-gray-800 to-gray-900 text-white transition-all duration-300 w-64 md:w-16 lg:w-64 md:translate-x-0 mobile-menu-closed md:mobile-menu-open">
            <!-- Sidebar Header -->
            <div class="p-5 border-b border-gray-700/50 flex items-center justify-between">
                <div class="flex items-center space-x-3 min-w-0">
                    <div class="bg-gradient-to-br from-orange-500 to-red-500 p-2.5 rounded-xl shadow-lg">
                        <i class="fas fa-store text-white text-lg"></i>
                    </div>
                    <span class="font-bold text-xl truncate logo-text hidden lg:block">MyStore Admin</span>
                </div>
                <button id="toggleSidebar" class="md:hidden text-gray-400 hover:text-white transition-colors p-1">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
            
            <!-- User Profile -->
            <div class="p-4 border-b border-gray-700/50 flex items-center space-x-3">
                <div class="h-10 w-10 rounded-full bg-gradient-to-br from-orange-400 to-red-500 flex items-center justify-center font-bold shadow-md">
                    <i class="fas fa-user text-white"></i>
                </div>
                <div class="flex-1 min-w-0 user-info hidden lg:block">
                    <h4 class="font-semibold text-sm truncate">{{ Auth::user()->name ?? 'Admin' }}</h4>
                    <p class="text-xs text-gray-400 truncate">Administrator</p>
                </div>
                <button id="collapseSidebar" class="text-gray-400 hover:text-white transition-colors p-1.5 hidden lg:block">
                    <i class="fas fa-chevron-left text-sm"></i>
                </button>
            </div>
            
            <!-- Navigation -->
            <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center space-x-3 p-3 rounded-xl transition-all duration-200 
                          {{ request()->routeIs('admin.dashboard') ? 'active-nav-item bg-gradient-to-r from-orange-900/40 to-transparent text-white' : 'text-gray-300 hover:text-white hover:bg-gray-800/50' }}">
                    <i class="fas fa-tachometer-alt w-5 text-center"></i>
                    <span class="flex-1 text-sm font-medium nav-text hidden lg:block">Dashboard</span>
                </a>
                
                <!-- Categories -->
                <a href="{{ route('admin.categories.index') }}" 
                   class="flex items-center space-x-3 p-3 rounded-xl transition-all duration-200 
                          {{ request()->routeIs('admin.categories*') ? 'active-nav-item bg-gradient-to-r from-orange-900/40 to-transparent text-white' : 'text-gray-300 hover:text-white hover:bg-gray-800/50' }}">
                    <i class="fas fa-tags w-5 text-center"></i>
                    <span class="flex-1 text-sm font-medium nav-text hidden lg:block">Categories</span>
                    <span class="bg-gradient-to-r from-blue-500 to-blue-600 text-xs px-2 py-1 rounded-full font-semibold badge-count hidden lg:block">{{ $categoryCount ?? 0 }}</span>
                </a>
                
                <!-- Products -->
                <a href="#" 
                   class="flex items-center space-x-3 p-3 rounded-xl transition-all duration-200 text-gray-300 hover:text-white hover:bg-gray-800/50">
                    <i class="fas fa-box w-5 text-center"></i>
                    <span class="flex-1 text-sm font-medium nav-text hidden lg:block">Products</span>
                    <span class="bg-gradient-to-r from-emerald-500 to-emerald-600 text-xs px-2 py-1 rounded-full font-semibold badge-count hidden lg:block">{{ $productCount ?? 0 }}</span>
                </a>
                
                <!-- Orders -->
                <a href="#" 
                   class="flex items-center space-x-3 p-3 rounded-xl transition-all duration-200 text-gray-300 hover:text-white hover:bg-gray-800/50">
                    <i class="fas fa-shopping-cart w-5 text-center"></i>
                    <span class="flex-1 text-sm font-medium nav-text hidden lg:block">Orders</span>
                    <span class="bg-gradient-to-r from-purple-500 to-purple-600 text-xs px-2 py-1 rounded-full font-semibold badge-count hidden lg:block">{{ $orderCount ?? 0 }}</span>
                </a>
                
                <!-- Users -->
                <a href="#" 
                   class="flex items-center space-x-3 p-3 rounded-xl transition-all duration-200 text-gray-300 hover:text-white hover:bg-gray-800/50">
                    <i class="fas fa-users w-5 text-center"></i>
                    <span class="flex-1 text-sm font-medium nav-text hidden lg:block">Users</span>
                    <span class="bg-gradient-to-r from-amber-500 to-amber-600 text-xs px-2 py-1 rounded-full font-semibold badge-count hidden lg:block">{{ $userCount ?? 0 }}</span>
                </a>
                
                <!-- Divider -->
                <div class="pt-4 mt-4 border-t border-gray-700/50">
                    <p class="text-xs text-gray-500 uppercase tracking-wider px-3 mb-2 section-title hidden lg:block">Settings</p>
                    <a href="#" 
                       class="flex items-center space-x-3 p-3 rounded-xl transition-all duration-200 text-gray-300 hover:text-white hover:bg-gray-800/50">
                        <i class="fas fa-cog w-5 text-center"></i>
                        <span class="flex-1 text-sm font-medium nav-text hidden lg:block">Settings</span>
                    </a>
                </div>
            </nav>

            <!-- Sidebar Footer -->
            <div class="p-4 border-t border-gray-700/50 sidebar-footer">
                <div class="hidden lg:block">
                    <div class="text-xs text-gray-500">
                        <p class="mb-1">© {{ date('Y') }} MyStore</p>
                        <p>v2.1.0</p>
                    </div>
                </div>
                <!-- Dark Mode Toggle (Optional) -->
                <button id="themeToggle" class="w-full hidden lg:flex items-center justify-center p-2 rounded-lg text-gray-400 hover:text-white hover:bg-gray-800/50 transition-colors mt-2">
                    <i class="fas fa-moon text-sm"></i>
                    <span class="ml-2 text-sm font-medium">Dark Mode</span>
                </button>
            </div>
        </aside>
        
        <!-- Main Content Area -->
        <div id="mainContent" class="flex-1 flex flex-col overflow-hidden transition-all duration-300 w-full">
            <!-- Top Header -->
            <header class="glass-effect border-b border-gray-200/50 sticky top-0 z-20">
                <div class="px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between h-16">
                        <!-- Left Section -->
                        <div class="flex items-center space-x-4">
                            <button id="mobileMenuToggle" class="md:hidden text-gray-700 hover:text-primary-600 transition-colors p-2">
                                <i class="fas fa-bars text-lg"></i>
                            </button>
                            
                            <div class="hidden sm:flex items-center space-x-2 text-sm">
                                <span class="text-gray-500">Admin</span>
                                <i class="fas fa-chevron-right text-xs text-gray-400"></i>
                                <span class="text-gray-900 font-semibold">@yield('page-title', 'Dashboard')</span>
                            </div>
                            
                            <!-- Quick Stats (Desktop) -->
                            <div class="hidden lg:flex items-center space-x-4 ml-4">
                                <div class="flex items-center space-x-2 text-sm">
                                    <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                                    <span class="text-gray-600">System Online</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Right Section -->
                        <div class="flex items-center space-x-4">
                            <!-- Search Bar -->
                            <div class="relative hidden md:block">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                                <input type="text" 
                                       id="searchInput"
                                       class="pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent w-64 transition-all duration-200 placeholder:text-gray-500"
                                       placeholder="Search users, products, orders...">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <kbd class="text-xs text-gray-400 bg-gray-100 px-1.5 py-0.5 rounded">⌘K</kbd>
                                </div>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="flex items-center space-x-2">
                                <!-- Quick Add Dropdown -->
                                <div class="relative">
                                    <button id="quickAddButton" class="p-2 text-gray-600 hover:text-primary-600 transition-colors relative">
                                        <i class="fas fa-plus-circle text-lg"></i>
                                    </button>
                                    <div id="quickAddMenu" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-gray-200 hidden z-50 animate-slide-up">
                                        <a href="{{ route('admin.categories.create') }}" class="flex items-center px-4 py-3 text-sm hover:bg-gray-50 transition-colors border-b border-gray-100">
                                            <i class="fas fa-tag text-primary-500 mr-3"></i>
                                            <span>New Category</span>
                                        </a>
                                        <a href="#" class="flex items-center px-4 py-3 text-sm hover:bg-gray-50 transition-colors">
                                            <i class="fas fa-box text-emerald-500 mr-3"></i>
                                            <span>New Product</span>
                                        </a>
                                    </div>
                                </div>
                                
                                <!-- Notifications -->
                                <div class="relative">
                                    <button id="notificationsButton" class="p-2 text-gray-600 hover:text-primary-600 transition-colors relative">
                                        <i class="fas fa-bell text-lg"></i>
                                        <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full animate-pulse"></span>
                                    </button>
                                    <div id="notificationsDropdown" class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-xl border border-gray-200 hidden z-50 animate-slide-up">
                                        <div class="p-4 border-b border-gray-100">
                                            <div class="flex items-center justify-between">
                                                <h3 class="font-semibold text-gray-900">Notifications</h3>
                                                <span class="text-xs bg-primary-100 text-primary-800 px-2 py-1 rounded-full">{{ $notificationCount ?? 5 }} new</span>
                                            </div>
                                        </div>
                                        <div class="max-h-96 overflow-y-auto">
                                            <div class="p-4 border-b border-gray-100 hover:bg-gray-50 transition-colors">
                                                <div class="flex items-start">
                                                    <div class="bg-blue-100 p-2 rounded-lg mr-3">
                                                        <i class="fas fa-user-plus text-blue-600"></i>
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <p class="font-medium text-gray-900 text-sm">New user registered</p>
                                                        <p class="text-gray-600 text-sm mt-0.5">John Doe just signed up</p>
                                                        <p class="text-gray-400 text-xs mt-1">2 minutes ago</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="p-3 border-t border-gray-100 text-center">
                                            <a href="#" class="text-primary-600 hover:text-primary-800 text-sm font-medium transition-colors">View all notifications</a>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- User Profile -->
                                <div class="relative">
                                    <button id="userDropdownButton" class="flex items-center space-x-3 focus:outline-none group">
                                        <div class="h-9 w-9 rounded-full bg-gradient-to-br from-orange-400 to-red-500 flex items-center justify-center font-bold text-white shadow-sm md:hidden">
                                            <i class="fas fa-user text-sm"></i>
                                        </div>
                                        <div class="hidden md:flex items-center space-x-3">
                                            <div class="text-right">
                                                <h4 class="font-medium text-sm text-gray-900">{{ Auth::user()->name ?? 'Admin' }}</h4>
                                                <p class="text-xs text-gray-500">Administrator</p>
                                            </div>
                                            <div class="h-9 w-9 rounded-full bg-gradient-to-br from-orange-400 to-red-500 flex items-center justify-center font-bold text-white shadow-sm">
                                                <i class="fas fa-user text-sm"></i>
                                            </div>
                                            <i class="fas fa-chevron-down text-gray-400 text-xs transition-transform group-hover:rotate-180"></i>
                                        </div>
                                    </button>
                                    
                                    <div id="userDropdown" class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-xl border border-gray-200 hidden z-50 animate-slide-up">
                                        <div class="p-4 border-b border-gray-100">
                                            <div class="flex items-center space-x-3">
                                                <div class="h-10 w-10 rounded-full bg-gradient-to-br from-orange-400 to-red-500 flex items-center justify-center font-bold text-white">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                                <div>
                                                    <h4 class="font-semibold text-gray-900 text-sm">{{ Auth::user()->name ?? 'Admin' }}</h4>
                                                    <p class="text-xs text-gray-500">{{ Auth::user()->email ?? 'admin@example.com' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="py-2">
                                            <a href="#" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                                <i class="fas fa-user-circle text-gray-400 mr-3"></i>
                                                <span>My Profile</span>
                                            </a>
                                            <a href="#" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                                <i class="fas fa-cog text-gray-400 mr-3"></i>
                                                <span>Account Settings</span>
                                            </a>
                                            <a href="#" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                                <i class="fas fa-bell text-gray-400 mr-3"></i>
                                                <span>Notifications</span>
                                            </a>
                                        </div>
                                        <div class="border-t border-gray-100 pt-2">
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <button type="submit" class="flex items-center px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 w-full transition-colors">
                                                    <i class="fas fa-sign-out-alt mr-3"></i>
                                                    <span>Logout</span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Main Content -->
            <main class="flex-1 overflow-y-auto bg-gradient-to-br from-gray-50 to-white p-4 sm:p-6 lg:p-8">
                <!-- Alert Messages -->
                @if(session('success'))
                    <div class="mb-6 animate-slide-up">
                        <div class="bg-gradient-to-r from-emerald-50 to-green-50 border border-emerald-200 rounded-xl p-4 flex items-center justify-between shadow-sm">
                            <div class="flex items-center">
                                <div class="bg-emerald-100 p-2 rounded-lg mr-3">
                                    <i class="fas fa-check-circle text-emerald-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-emerald-900">{{ session('success') }}</p>
                                    <p class="text-emerald-700 text-sm mt-0.5">Operation completed successfully</p>
                                </div>
                            </div>
                            <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 transition-colors p-1">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-6 animate-slide-up">
                        <div class="bg-gradient-to-r from-red-50 to-orange-50 border border-red-200 rounded-xl p-4">
                            <div class="flex items-center mb-3">
                                <div class="bg-red-100 p-2 rounded-lg mr-3">
                                    <i class="fas fa-exclamation-circle text-red-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-red-900">Please fix the following errors</p>
                                    <p class="text-red-700 text-sm mt-0.5">There were some issues with your submission</p>
                                </div>
                            </div>
                            <ul class="list-disc list-inside text-red-700 text-sm space-y-1 ml-10">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <!-- Page Content -->
                <div class="animate-fade-in">
                    @yield('content')
                </div>
                
                <!-- Footer -->
                <footer class="mt-12 pt-8 border-t border-gray-200">
                    <div class="flex flex-col sm:flex-row items-center justify-between text-sm text-gray-500">
                        <div class="mb-4 sm:mb-0">
                            <p>&copy; {{ date('Y') }} MyStore Admin Panel. All rights reserved.</p>
                            <p class="mt-1 text-xs">Built with <i class="fas fa-heart text-red-500 mx-0.5"></i> and Laravel</p>
                        </div>
                        <div class="flex items-center space-x-4">
                            <span>Version 2.1.0</span>
                            <span class="hidden sm:inline">•</span>
                            <span>Last updated: {{ now()->format('M d, Y') }}</span>
                        </div>
                    </div>
                </footer>
            </main>
        </div>
    </div>

    <script>
        // DOM Elements
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const toggleSidebar = document.getElementById('toggleSidebar');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const collapseSidebar = document.getElementById('collapseSidebar');
        const mainContent = document.getElementById('mainContent');
        const searchInput = document.getElementById('searchInput');
        
        // Dropdown Elements
        const quickAddButton = document.getElementById('quickAddButton');
        const quickAddMenu = document.getElementById('quickAddMenu');
        const notificationsButton = document.getElementById('notificationsButton');
        const notificationsDropdown = document.getElementById('notificationsDropdown');
        const userDropdownButton = document.getElementById('userDropdownButton');
        const userDropdown = document.getElementById('userDropdown');
        
        // State Management
        let isSidebarCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';

        // Initialize Sidebar State
        function initializeSidebar() {
            if (window.innerWidth >= 1024) {
                if (isSidebarCollapsed) {
                    collapseSidebarToIcons();
                } else {
                    expandSidebar();
                }
            } else if (window.innerWidth >= 768) {
                // Tablet view - always collapsed
                sidebar.classList.remove('lg:w-64', 'sidebar-expanded');
                sidebar.classList.add('md:w-16', 'sidebar-collapsed');
                mainContent.classList.remove('lg:ml-64');
                mainContent.classList.add('md:ml-16');
            }
        }

        // Collapse Sidebar to Icons
        function collapseSidebarToIcons() {
            sidebar.classList.remove('lg:w-64', 'sidebar-expanded');
            sidebar.classList.add('lg:w-16', 'sidebar-collapsed');
            collapseSidebar.innerHTML = '<i class="fas fa-chevron-right text-sm"></i>';
            isSidebarCollapsed = true;
            localStorage.setItem('sidebarCollapsed', 'true');
        }

        // Expand Sidebar
        function expandSidebar() {
            sidebar.classList.remove('lg:w-16', 'sidebar-collapsed');
            sidebar.classList.add('lg:w-64', 'sidebar-expanded');
            collapseSidebar.innerHTML = '<i class="fas fa-chevron-left text-sm"></i>';
            isSidebarCollapsed = false;
            localStorage.setItem('sidebarCollapsed', 'false');
        }

        // Mobile Sidebar Toggle
        mobileMenuToggle?.addEventListener('click', () => {
            sidebar.classList.remove('mobile-menu-closed');
            sidebar.classList.add('mobile-menu-open');
            sidebarOverlay.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        });

        toggleSidebar?.addEventListener('click', () => {
            sidebar.classList.remove('mobile-menu-open');
            sidebar.classList.add('mobile-menu-closed');
            sidebarOverlay.classList.add('hidden');
            document.body.style.overflow = '';
        });

        sidebarOverlay?.addEventListener('click', () => {
            sidebar.classList.remove('mobile-menu-open');
            sidebar.classList.add('mobile-menu-closed');
            sidebarOverlay.classList.add('hidden');
            document.body.style.overflow = '';
        });

        // Desktop Sidebar Collapse/Expand
        collapseSidebar?.addEventListener('click', () => {
            if (window.innerWidth >= 1024) {
                if (isSidebarCollapsed) {
                    expandSidebar();
                } else {
                    collapseSidebarToIcons();
                }
            }
        });

        // Dropdown Toggles
        quickAddButton?.addEventListener('click', (e) => {
            e.stopPropagation();
            quickAddMenu.classList.toggle('hidden');
            notificationsDropdown.classList.add('hidden');
            userDropdown.classList.add('hidden');
        });

        notificationsButton?.addEventListener('click', (e) => {
            e.stopPropagation();
            notificationsDropdown.classList.toggle('hidden');
            quickAddMenu.classList.add('hidden');
            userDropdown.classList.add('hidden');
        });

        userDropdownButton?.addEventListener('click', (e) => {
            e.stopPropagation();
            userDropdown.classList.toggle('hidden');
            quickAddMenu.classList.add('hidden');
            notificationsDropdown.classList.add('hidden');
        });

        // Close All Dropdowns on Outside Click
        document.addEventListener('click', (e) => {
            if (!quickAddButton?.contains(e.target) && !quickAddMenu?.contains(e.target)) {
                quickAddMenu.classList.add('hidden');
            }
            
            if (!notificationsButton?.contains(e.target) && !notificationsDropdown?.contains(e.target)) {
                notificationsDropdown.classList.add('hidden');
            }
            
            if (!userDropdownButton?.contains(e.target) && !userDropdown?.contains(e.target)) {
                userDropdown.classList.add('hidden');
            }
        });

        // Search Functionality
        searchInput?.addEventListener('keyup', (e) => {
            if (e.key === 'Enter' && searchInput.value.trim()) {
                console.log('Searching for:', searchInput.value);
                // Implement search functionality
                searchInput.value = '';
            }
        });

        // Keyboard Shortcuts
        document.addEventListener('keydown', (e) => {
            // Cmd/Ctrl + K for search
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                searchInput?.focus();
            }
            
            // Escape to close dropdowns
            if (e.key === 'Escape') {
                quickAddMenu.classList.add('hidden');
                notificationsDropdown.classList.add('hidden');
                userDropdown.classList.add('hidden');
            }
        });

        // Auto-hide alerts after 5 seconds
        setTimeout(() => {
            const alerts = document.querySelectorAll('.animate-slide-up');
            alerts.forEach(alert => {
                if (alert.closest('.bg-gradient-to-r')) {
                    setTimeout(() => {
                        alert.style.opacity = '0';
                        alert.style.transform = 'translateY(-10px)';
                        setTimeout(() => alert.remove(), 300);
                    }, 5000);
                }
            });
        }, 1000);

        // Handle Responsive Behavior
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 768) {
                sidebar.classList.remove('mobile-menu-open', 'mobile-menu-closed', 'hidden');
                sidebarOverlay.classList.add('hidden');
                document.body.style.overflow = '';
                
                if (window.innerWidth < 1024) {
                    // Tablet view
                    sidebar.classList.remove('lg:w-64', 'sidebar-expanded');
                    sidebar.classList.add('md:w-16', 'sidebar-collapsed');
                } else {
                    // Desktop view - restore saved state
                    initializeSidebar();
                }
            }
        });

        // Initialize on Page Load
        document.addEventListener('DOMContentLoaded', () => {
            initializeSidebar();
            
            // Set active nav item based on current URL
            const currentPath = window.location.pathname;
            document.querySelectorAll('nav a').forEach(link => {
                if (link.getAttribute('href') === currentPath || 
                    (currentPath.startsWith(link.getAttribute('href')) && link.getAttribute('href') !== '/')) {
                    link.classList.add('active-nav-item', 'bg-gradient-to-r', 'from-orange-900/40', 'to-transparent', 'text-white');
                    link.classList.remove('text-gray-300', 'hover:text-white', 'hover:bg-gray-800/50');
                }
            });
            
            // Add loading animation to buttons with loading class
            document.querySelectorAll('button[type="submit"]').forEach(button => {
                button.addEventListener('click', function() {
                    if (this.classList.contains('loading')) {
                        this.innerHTML = '<span class="loading-dots"><span></span><span></span><span></span></span>';
                        this.disabled = true;
                    }
                });
            });
        });

        // Theme Toggle (Optional)
        const themeToggle = document.getElementById('themeToggle');
        themeToggle?.addEventListener('click', () => {
            document.documentElement.classList.toggle('dark');
            const isDark = document.documentElement.classList.contains('dark');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            themeToggle.innerHTML = isDark 
                ? '<i class="fas fa-sun text-sm"></i><span class="ml-2 text-sm font-medium">Light Mode</span>'
                : '<i class="fas fa-moon text-sm"></i><span class="ml-2 text-sm font-medium">Dark Mode</span>';
        });

        // Load saved theme
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme === 'dark') {
            document.documentElement.classList.add('dark');
            themeToggle.innerHTML = '<i class="fas fa-sun text-sm"></i><span class="ml-2 text-sm font-medium">Light Mode</span>';
        }

        @stack('scripts')
    </script>
</body>
</html>