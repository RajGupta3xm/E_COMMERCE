@extends('layouts.admin')

@section('title', 'Brands')

@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="md:flex md:items-center md:justify-between mb-6">
                <div class="flex-1 min-w-0">
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                        Brands
                    </h2>
                    <p class="mt-1 text-sm text-gray-500">
                        Manage your product brands and manufacturers.
                    </p>
                </div>
                <div class="mt-4 flex md:mt-0 md:ml-4 gap-3">
                    <a href="{{ route('admin.brands.import') }}"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M12 3v13.5m0 0l-4.5-4.5M12 16.5l4.5-4.5" />
                        </svg>
                        Import Brands
                    </a>
                    <a href="{{ route('admin.brands.create') }}"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Add Brand
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-3 mb-6">
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-100 p-3 rounded-md">
                                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            <div class="ml-5">
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Brands</dt>
                                <dd class="text-lg font-bold text-blue-0">{{ $brands->total() }}</dd>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-100 p-3 rounded-md">
                                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-5">
                                <dt class="text-sm font-medium text-gray-500">Active Brands</dt>
                                <dd class="text-lg font-bold text-gray-900">{{ \App\Models\Brand::where('is_active', true)->count() }}</dd>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-red-100 p-3 rounded-md">
                                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                            <div class="ml-5">
                                <dt class="text-sm font-medium text-gray-500">Inactive Brands</dt>
                                <dd class="text-lg font-bold text-gray-900">{{ \App\Models\Brand::where('is_active', false)->count() }}</dd>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow overflow-hidden sm:rounded-md">
                <div class="px-4 py-4 border-b border-gray-200 sm:px-6">
                    <div class="flex flex-col sm:flex-row gap-4 items-center justify-between">
                        <div class="relative w-full sm:w-64">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </span>
                           <input type="search" id="brand-search" data-url="{{ route('admin.brands.index') }}" placeholder="Search brands..." class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            {{-- <input type="search" id="brand-search" data-url="{{ route('admin.brands.index') }}" placeholder="Search brands..." class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 sm:text-sm"> --}}
                        </div>

                        <div class="flex gap-3 w-full sm:w-auto">
                            <select id="status-filter" class="block w-full sm:w-40 rounded-md border-gray-300 py-2 text-sm focus:ring-blue-500">
                                <option value="">All Status</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                            {{-- <button class="bg-gray-100 px-4 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-200" id="reset-filter">Reset</button> --}}
                            <button id="reset-filter" type="button" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
    Reset
</button>
                        </div>
                       
                    </div>
                </div>

                <ul class="divide-y divide-gray-200" id="brands-list-container">
                    @forelse($brands as $brand)
                        <li class="hover:bg-gray-50 transition">
                            <div class="px-4 py-4 sm:px-6 flex items-center justify-between">
                                <div class="flex items-center min-w-0">
                                    <div class="flex-shrink-0 h-14 w-14 border rounded-lg bg-gray-50 flex items-center justify-center overflow-hidden">
                                        @if($brand->logo)
                                            <img src="{{ asset('storage/' . $brand->logo) }}" alt="{{ $brand->name }}" class="h-full w-full object-contain p-1">
                                        @else
                                            <span class="text-xs text-gray-400 font-bold uppercase">{{ substr($brand->name, 0, 2) }}</span>
                                        @endif
                                    </div>

                                    <div class="ml-4 min-w-0">
                                        <div class="flex items-center">
                                            <a href="{{ route('admin.brands.edit', $brand) }}" class="text-sm font-bold text-blue-600 truncate hover:underline">
                                                {{ $brand->name }}
                                            </a>
                                            @if($brand->is_featured)
                                                <span class="ml-2 px-2 py-0.5 text-xs bg-yellow-100 text-yellow-800 rounded-full font-medium">Featured</span>
                                            @endif
                                        </div>
                                        <div class="mt-1 flex items-center text-xs text-gray-500 gap-3">
                                            <span class="flex items-center">
                                                <svg class="mr-1 h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                                </svg>
                                                {{ $brand->products_count ?? 0 }} Products
                                            </span>
                                            <span>Added {{ $brand->created_at->format('M d, Y') }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center space-x-4">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <label class="inline-flex relative items-center cursor-pointer group">
                                                <input type="checkbox" 
                                                    class="sr-only peer status-toggle" 
                                                    data-id="{{ $brand->id }}" 
                                                    {{ $brand->is_active ? 'checked' : '' }}>
                                                
                                                <div class="w-12 h-6 bg-gray-200 rounded-full 
                                                            peer-checked:bg-indigo-600 
                                                            peer-focus:ring-4 peer-focus:ring-indigo-100 
                                                            transition-all duration-300 relative">
                                                    
                                                    <div class="absolute top-[4px] left-[4px] bg-white w-4 h-4 rounded-full 
                                                                shadow-sm transition-all duration-300 
                                                                peer-checked:translate-x-6">
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </td>
                                    
                                    <div class="flex items-center space-x-2">
                                       <a href="{{ route('admin.brands.edit', $brand) }}" 
                                            class="edit-brand-btn text-gray-400 hover:text-blue-600 transition-colors"
                                            data-name="{{ $brand->name }}">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                        </a>
                                       <button type="button" 
                                                class="delete-brand-btn text-gray-400 hover:text-red-600 transition-colors" 
                                                data-id="{{ $brand->id }}" 
                                                data-name="{{ $brand->name }}">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center">
                                <div class="flex flex-col items-center">
                                    <svg class="h-12 w-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    <p class="text-gray-500 font-medium">No brands found matching your criteria.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </ul>

                @if($brands->hasPages())
                    <div class="bg-white px-4 py-3 border-t border-gray-200">
                        {{ $brands->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Global configurations for brand.js
    window.BrandConfig = {
        fetchUrl: "{{ route('admin.brands.index') }}",
        toggleUrl: "{{ route('admin.brands.toggleStatus') }}",
        deleteUrl: "{{ route('admin.brands.destroy', ':id') }}",
        csrfToken: "{{ csrf_token() }}",
        storagePath: "{{ asset('storage/') }}"
    };
</script>
<script src="{{ asset('js/admin/brand.js') }}"></script>

@endpush
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/brands/toggle.css') }}">
@endpush