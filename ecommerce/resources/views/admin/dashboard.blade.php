@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-8 fade-in">
    <!-- Welcome Header -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Dashboard Overview</h1>
            <p class="text-gray-600 mt-2">Welcome back, {{ Auth::user()->name ?? 'Admin' }}! Here's what's happening with your store today.</p>
        </div>
        <button class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-xl font-medium transition-all shadow-md shadow-orange-200 hover:shadow-orange-300 mt-4 sm:mt-0 flex items-center">
            <i class="fas fa-download mr-2"></i> Export Report
        </button>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Products -->
        <div class="group bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 stat-card">
            <div class="flex items-center justify-between">
                <div class="p-3 bg-blue-50 text-blue-600 rounded-xl group-hover:bg-blue-600 group-hover:text-white transition-colors">
                    <i class="fas fa-box-open text-2xl"></i>
                </div>
                <span class="text-xs font-bold text-green-500 bg-green-50 px-3 py-1 rounded-full">+12.5%</span>
            </div>
            <div class="mt-4">
                <p class="text-sm font-semibold text-gray-400 uppercase tracking-wider">Total Products</p>
                <h2 class="text-4xl font-black text-gray-800 mt-1">856</h2>
                <p class="text-sm text-gray-500 mt-2"><i class="fas fa-arrow-up text-green-500 mr-1"></i> 45 new this month</p>
            </div>
        </div>

        <!-- Categories -->
        <div class="group bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 stat-card">
            <div class="flex items-center justify-between">
                <div class="p-3 bg-purple-50 text-purple-600 rounded-xl group-hover:bg-purple-600 group-hover:text-white transition-colors">
                    <i class="fas fa-tags text-2xl"></i>
                </div>
                <span class="text-xs font-bold text-orange-500 bg-orange-50 px-3 py-1 rounded-full">3 New</span>
            </div>
            <div class="mt-4">
                <p class="text-sm font-semibold text-gray-400 uppercase tracking-wider">Categories</p>
                <h2 class="text-4xl font-black text-gray-800 mt-1">42</h2>
                <p class="text-sm text-gray-500 mt-2"><i class="fas fa-layer-group text-purple-500 mr-1"></i> All active</p>
            </div>
        </div>

        <!-- Total Orders -->
        <div class="group bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 stat-card">
            <div class="flex items-center justify-between">
                <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                    <i class="fas fa-shopping-cart text-2xl"></i>
                </div>
                <span class="text-xs font-bold text-blue-500 bg-blue-50 px-3 py-1 rounded-full">8 Pending</span>
            </div>
            <div class="mt-4">
                <p class="text-sm font-semibold text-gray-400 uppercase tracking-wider">Total Orders</p>
                <h2 class="text-4xl font-black text-gray-800 mt-1">1,254</h2>
                <p class="text-sm text-gray-500 mt-2"><i class="fas fa-clock text-orange-500 mr-1"></i> 12 pending today</p>
            </div>
        </div>

        <!-- Total Revenue -->
        <div class="group bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 stat-card">
            <div class="flex items-center justify-between">
                <div class="p-3 bg-orange-50 text-orange-600 rounded-xl group-hover:bg-orange-600 group-hover:text-white transition-colors">
                    <i class="fas fa-rupee-sign text-2xl px-1"></i>
                </div>
                <span class="text-xs font-bold text-green-500 bg-green-50 px-3 py-1 rounded-full">+8.2%</span>
            </div>
            <div class="mt-4">
                <p class="text-sm font-semibold text-gray-400 uppercase tracking-wider">Total Revenue</p>
                <h2 class="text-4xl font-black text-gray-800 mt-1">₹1,85,000</h2>
                <p class="text-sm text-gray-500 mt-2"><i class="fas fa-chart-line text-green-500 mr-1"></i> This month</p>
            </div>
        </div>
    </div>

    <!-- Performance Banner -->
    <div class="bg-gradient-to-r from-orange-500 to-red-500 rounded-3xl p-8 text-white flex flex-col md:flex-row items-center justify-between shadow-2xl overflow-hidden relative">
        <div class="z-10">
            <h3 class="text-2xl font-bold">🎉 Store is performing 20% better!</h3>
            <p class="text-orange-100 mt-2">Your marketing campaigns are driving excellent results. Keep it up!</p>
        </div>
        <div class="mt-6 md:mt-0 z-10">
            <a href="#" class="inline-block bg-white text-orange-600 px-8 py-3 rounded-full font-bold hover:bg-gray-100 hover:scale-105 transition-all shadow-lg">
                View Analytics <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
        <div class="absolute -right-10 -bottom-10 w-60 h-60 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute -left-10 top-10 w-40 h-40 bg-white/5 rounded-full blur-3xl"></div>
    </div>

    <!-- Charts and Tables Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Orders -->
        <div class="bg-white rounded-2xl shadow-sm border overflow-hidden">
            <div class="px-6 py-4 border-b flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-900">Recent Orders</h2>
                <a href="#" class="text-orange-600 hover:text-orange-800 text-sm font-medium">View All</a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @for($i = 1; $i <= 5; $i++)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#ORD-78{{ 40 + $i }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Customer {{ $i }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 text-xs rounded-full {{ $i % 3 == 0 ? 'bg-green-100 text-green-800' : ($i % 3 == 1 ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800') }}">
                                    {{ $i % 3 == 0 ? 'Completed' : ($i % 3 == 1 ? 'Pending' : 'Processing') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">₹{{ 1000 + ($i * 500) }}</td>
                        </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Recent Users -->
        <div class="bg-white rounded-2xl shadow-sm border overflow-hidden">
            <div class="px-6 py-4 border-b flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-900">Recent Users</h2>
                <a href="#" class="text-orange-600 hover:text-orange-800 text-sm font-medium">View All</a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @for($i = 1; $i <= 5; $i++)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center font-bold text-white mr-3">
                                        {{ strtoupper(substr("User $i", 0, 2)) }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">User {{ $i }}</div>
                                        <div class="text-sm text-gray-500">user{{ $i }}@example.com</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ now()->subDays($i)->format('M d, Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 text-xs rounded-full {{ $i % 2 == 0 ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $i % 2 == 0 ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                        </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-2xl shadow-sm border p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-6">Quick Actions</h2>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-6">
            <a href="{{ route('admin.categories.create') }}" class="flex flex-col items-center justify-center p-6 border-2 border-gray-100 rounded-xl hover:border-orange-200 hover:bg-orange-50 transition-all group">
                <div class="bg-orange-100 p-4 rounded-full mb-4 group-hover:bg-orange-500 transition-colors">
                    <i class="fas fa-plus text-orange-600 text-2xl group-hover:text-white"></i>
                </div>
                <span class="text-sm font-medium text-gray-900 group-hover:text-orange-600">Add Category</span>
            </a>
            
            <a href="#" class="flex flex-col items-center justify-center p-6 border-2 border-gray-100 rounded-xl hover:border-blue-200 hover:bg-blue-50 transition-all group">
                <div class="bg-blue-100 p-4 rounded-full mb-4 group-hover:bg-blue-500 transition-colors">
                    <i class="fas fa-box text-blue-600 text-2xl group-hover:text-white"></i>
                </div>
                <span class="text-sm font-medium text-gray-900 group-hover:text-blue-600">Add Product</span>
            </a>
            
            <a href="#" class="flex flex-col items-center justify-center p-6 border-2 border-gray-100 rounded-xl hover:border-purple-200 hover:bg-purple-50 transition-all group">
                <div class="bg-purple-100 p-4 rounded-full mb-4 group-hover:bg-purple-500 transition-colors">
                    <i class="fas fa-chart-bar text-purple-600 text-2xl group-hover:text-white"></i>
                </div>
                <span class="text-sm font-medium text-gray-900 group-hover:text-purple-600">View Reports</span>
            </a>
            
            <a href="#" class="flex flex-col items-center justify-center p-6 border-2 border-gray-100 rounded-xl hover:border-green-200 hover:bg-green-50 transition-all group">
                <div class="bg-green-100 p-4 rounded-full mb-4 group-hover:bg-green-500 transition-colors">
                    <i class="fas fa-cog text-green-600 text-2xl group-hover:text-white"></i>
                </div>
                <span class="text-sm font-medium text-gray-900 group-hover:text-green-600">Settings</span>
            </a>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Initialize any dashboard-specific JavaScript here
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Dashboard loaded');
        
        // Add any dashboard-specific interactions here
        const statCards = document.querySelectorAll('.stat-card');
        statCards.forEach((card, index) => {
            card.style.animationDelay = `${index * 100}ms`;
        });
    });
</script>
@endpush
@endsection