{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h1 class="text-2xl font-bold text-gray-900">
                        Dashboard Overview
                    </h1>
                    <p class="mt-1 text-sm text-gray-600">
                        Welcome back, {{ Auth::user()->name }}! Here's what's happening with your store.
                    </p>
                </div>
                <div class="mt-4 flex md:mt-0 md:ml-4">
                    <button type="button" 
                            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="-ml-1 mr-2 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Export Report
                    </button>
                    <a href="{{ route('admin.categories.create') }}" 
                       class="ml-3 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Add Category
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Stats Grid -->
        <div class="px-4 mb-8 sm:px-0">
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                <!-- Total Categories Card -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="h-10 w-10 rounded-lg bg-blue-100 flex items-center justify-center">
                                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">
                                        Total Categories
                                    </dt>
                                    <dd class="text-xl font-bold text-gray-900">
                                        {{ \App\Models\Category::count() }}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-5 py-3">
                        <div class="text-sm">
                            <span class="text-green-600 font-medium">
                                +{{ \App\Models\Category::count() > 0 ? '12' : '0' }}%
                            </span>
                            <span class="text-gray-500"> from last month</span>
                        </div>
                    </div>
                </div>

                <!-- Active Categories Card -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="h-10 w-10 rounded-lg bg-green-100 flex items-center justify-center">
                                    <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">
                                        Active Categories
                                    </dt>
                                    <dd class="text-xl font-bold text-gray-900">
                                        {{ \App\Models\Category::where('is_active', true)->count() }}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-5 py-3">
                        <div class="text-sm">
                            <span class="font-medium text-gray-900">
                                {{ \App\Models\Category::count() > 0 ? 
                                   round((\App\Models\Category::where('is_active', true)->count() / \App\Models\Category::count()) * 100, 1) : 0 }}%
                            </span>
                            <span class="text-gray-500"> active rate</span>
                        </div>
                    </div>
                </div>

                <!-- Main Categories Card -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="h-10 w-10 rounded-lg bg-indigo-100 flex items-center justify-center">
                                    <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">
                                        Main Categories
                                    </dt>
                                    <dd class="text-xl font-bold text-gray-900">
                                        {{ \App\Models\Category::whereNull('parent_id')->count() }}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-5 py-3">
                        <div class="text-sm">
                            <span class="font-medium text-gray-900">
                                @php
                                    $parentCount = \App\Models\Category::whereNull('parent_id')->count();
                                    $childCount = \App\Models\Category::whereNotNull('parent_id')->count();
                                    $average = $parentCount > 0 ? round($childCount / $parentCount, 1) : 0;
                                @endphp
                                {{ $average }}
                            </span>
                            <span class="text-gray-500"> avg sub-categories</span>
                        </div>
                    </div>
                </div>

                <!-- Sub Categories Card -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="h-10 w-10 rounded-lg bg-purple-100 flex items-center justify-center">
                                    <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">
                                        Sub Categories
                                    </dt>
                                    <dd class="text-xl font-bold text-gray-900">
                                        {{ \App\Models\Category::whereNotNull('parent_id')->count() }}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-5 py-3">
                        <div class="text-sm">
                            <span class="font-medium text-gray-900">
                                {{ \App\Models\Category::whereNotNull('parent_id')->count() }}
                            </span>
                            <span class="text-gray-500"> child categories</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Categories & Stats -->
        <div class="px-4 sm:px-0">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Recent Categories -->
                <div class="lg:col-span-2">
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-medium text-gray-900">
                                    Recent Categories
                                </h3>
                                <a href="{{ route('admin.categories.index') }}" 
                                   class="text-sm font-medium text-blue-600 hover:text-blue-500">
                                    View all →
                                </a>
                            </div>
                        </div>
                        <div class="divide-y divide-gray-200">
                            @forelse(\App\Models\Category::latest()->take(6)->get() as $category)
                            <div class="px-4 py-4 sm:px-6 hover:bg-gray-50">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 mr-4">
                                        @if($category->image)
                                        <img class="h-10 w-10 rounded-lg object-cover" 
                                             src="{{ asset('storage/' . $category->image) }}" 
                                             alt="{{ $category->name }}">
                                        @else
                                        <div class="h-10 w-10 rounded-lg bg-gray-100 flex items-center justify-center">
                                            <span class="text-gray-500 font-medium">{{ substr($category->name, 0, 1) }}</span>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">
                                            {{ $category->name }}
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            {{ $category->parent ? 'Sub-category of ' . $category->parent->name : 'Main Category' }}
                                        </p>
                                    </div>
                                    <div class="ml-4 flex-shrink-0">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                            {{ $category->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $category->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="px-4 py-8 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                </svg>
                                <p class="mt-2 text-sm text-gray-500">No categories found</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Category Stats -->
                <div class="space-y-8">
                    <!-- Quick Actions -->
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">
                                Quick Actions
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                <a href="{{ route('admin.categories.create') }}" 
                                   class="group flex items-center p-3 border border-gray-200 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-colors">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-lg bg-blue-100 flex items-center justify-center">
                                        <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-gray-900">Add Category</p>
                                        <p class="text-xs text-gray-500">Create new product category</p>
                                    </div>
                                    <div class="ml-auto">
                                        <svg class="h-5 w-5 text-gray-400 group-hover:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </div>
                                </a>

                                <a href="{{ route('admin.categories.index') }}" 
                                   class="group flex items-center p-3 border border-gray-200 rounded-lg hover:border-green-500 hover:bg-green-50 transition-colors">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-lg bg-green-100 flex items-center justify-center">
                                        <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-gray-900">Manage All</p>
                                        <p class="text-xs text-gray-500">View all categories</p>
                                    </div>
                                    <div class="ml-auto">
                                        <svg class="h-5 w-5 text-gray-400 group-hover:text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Status Distribution -->
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">
                                Status Distribution
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                <div>
                                    <div class="flex items-center justify-between mb-1">
                                        <span class="text-sm font-medium text-gray-700">Active Categories</span>
                                        <span class="text-sm font-medium text-gray-900">
                                            {{ \App\Models\Category::where('is_active', true)->count() }}
                                        </span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-green-600 h-2 rounded-full" 
                                             style="width: {{ \App\Models\Category::count() > 0 ? 
                                                       (\App\Models\Category::where('is_active', true)->count() / \App\Models\Category::count()) * 100 : 0 }}%">
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <div class="flex items-center justify-between mb-1">
                                        <span class="text-sm font-medium text-gray-700">Inactive Categories</span>
                                        <span class="text-sm font-medium text-gray-900">
                                            {{ \App\Models\Category::where('is_active', false)->count() }}
                                        </span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-red-600 h-2 rounded-full" 
                                             style="width: {{ \App\Models\Category::count() > 0 ? 
                                                       (\App\Models\Category::where('is_active', false)->count() / \App\Models\Category::count()) * 100 : 0 }}%">
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <div class="flex items-center justify-between mb-1">
                                        <span class="text-sm font-medium text-gray-700">Main Categories</span>
                                        <span class="text-sm font-medium text-gray-900">
                                            {{ \App\Models\Category::whereNull('parent_id')->count() }}
                                        </span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-blue-600 h-2 rounded-full" 
                                             style="width: {{ \App\Models\Category::count() > 0 ? 
                                                       (\App\Models\Category::whereNull('parent_id')->count() / \App\Models\Category::count()) * 100 : 0 }}%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Categories with Most Sub-categories -->
        <div class="mt-8 px-4 sm:px-0">
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">
                        Top Categories
                    </h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Categories with the most sub-categories
                    </p>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach(\App\Models\Category::withCount('children')->whereNull('parent_id')->orderByDesc('children_count')->take(3)->get() as $category)
                        <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-300 transition-colors">
                            <div class="flex items-center mb-3">
                                @if($category->image)
                                <img class="h-12 w-12 rounded-lg object-cover mr-3" 
                                     src="{{ asset('storage/' . $category->image) }}" 
                                     alt="{{ $category->name }}">
                                @else
                                <div class="h-12 w-12 rounded-lg bg-gray-100 flex items-center justify-center mr-3">
                                    <span class="text-gray-600 font-bold">{{ substr($category->name, 0, 1) }}</span>
                                </div>
                                @endif
                                <div>
                                    <h4 class="font-medium text-gray-900">{{ $category->name }}</h4>
                                    <p class="text-sm text-gray-500">{{ $category->children_count }} sub-categories</p>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-xs px-2 py-1 rounded-full 
                                    {{ $category->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $category->is_active ? 'Active' : 'Inactive' }}
                                </span>
                                <a href="{{ route('admin.categories.edit', $category) }}" 
                                   class="text-xs text-blue-600 hover:text-blue-800">
                                    Edit →
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    @if(\App\Models\Category::whereNull('parent_id')->count() == 0)
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                        <p class="mt-2 text-sm text-gray-500">No main categories found</p>
                        <a href="{{ route('admin.categories.create') }}" 
                           class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                            Create your first category
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </main>
</div>
@endsection