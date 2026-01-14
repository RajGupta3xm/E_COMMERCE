{{-- resources/views/admin/brands/create.blade.php --}}
@extends('layouts.admin')

@section('title', 'Create Brand')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Add New Brand</h1>
                    <p class="mt-1 text-sm text-gray-600">Create a new product brand/manufacturer</p>
                </div>
                <div>
                    <a href="{{ route('admin.brands.index') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="-ml-1 mr-2 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Back to Brands
                    </a>
                </div>
            </div>
        </div>

        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <form action="{{ route('admin.brands.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="px-4 py-5 sm:p-6">
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div class="space-y-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">
                                    Brand Name *
                                </label>
                                <div class="mt-1">
                                    <input type="text" 
                                           name="name" 
                                           id="name" 
                                           value="{{ old('name') }}"
                                           class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md @error('name') border-red-300 @enderror"
                                           placeholder="e.g., Samsung, Nike">
                                    @error('name')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label for="slug" class="block text-sm font-medium text-gray-700">
                                    Slug
                                </label>
                                <div class="mt-1">
                                    <input type="text" 
                                           name="slug" 
                                           id="slug" 
                                           value="{{ old('slug') }}"
                                           class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md @error('slug') border-red-300 @enderror"
                                           placeholder="e.g., samsung">
                                    <p class="mt-2 text-sm text-gray-500">Leave empty to auto-generate</p>
                                    @error('slug')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="flex items-center pt-2">
                                <input id="is_active" 
                                       name="is_active" 
                                       type="checkbox" 
                                       value="1" 
                                       {{ old('is_active', true) ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="is_active" class="ml-2 block text-sm text-gray-900">
                                    Active Brand (Visible on frontend)
                                </label>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div>
                                <label for="logo" class="block text-sm font-medium text-gray-700">
                                    Brand Logo
                                </label>
                                <div class="mt-1 flex flex-col items-start">
                                    <input type="file" 
                                           name="logo" 
                                           id="logo" 
                                           onchange="previewImage(this)"
                                           class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md @error('logo') border-red-300 @enderror"
                                           accept="image/*">
                                    <p class="mt-2 text-sm text-gray-500">Square logo works best (Max: 2MB)</p>
                                    @error('logo')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6 border-t border-gray-200">
                    <button type="button" 
                            onclick="window.location='{{ route('admin.brands.index') }}'"
                            class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Create Brand
                    </button>
                </div>
            </form>
        </div>

        <div class="mt-6 bg-white shadow sm:rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Brand Preview</h3>
                <div class="border border-gray-200 rounded-lg p-6 w-full max-w-xs text-center">
                    <div class="mx-auto h-24 w-24 bg-gray-100 rounded-lg flex items-center justify-center overflow-hidden mb-4">
                        <img id="logo-preview" src="#" alt="Logo Preview" class="hidden max-h-full max-w-full object-contain">
                        <svg id="placeholder-icon" class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h4 id="preview-name" class="text-xl font-bold text-gray-900">Brand Name</h4>
                        <p id="preview-slug" class="text-sm text-gray-500 italic">brand-slug-url</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Auto-generate slug and update preview
    document.getElementById('name').addEventListener('input', function() {
        const name = this.value;
        const slugField = document.getElementById('slug');
        
        document.getElementById('preview-name').textContent = name || 'Brand Name';
        
        if (!slugField.dataset.edited) {
            const slug = name.toLowerCase()
                .replace(/[^\w\s]/gi, '')
                .replace(/\s+/g, '-')
                .trim();
            slugField.value = slug;
            document.getElementById('preview-slug').textContent = slug || 'brand-slug-url';
        }
    });

    document.getElementById('slug').addEventListener('input', function() {
        this.dataset.edited = true;
        document.getElementById('preview-slug').textContent = this.value || 'brand-slug-url';
    });

    // Image Preview Logic
    function previewImage(input) {
        const preview = document.getElementById('logo-preview');
        const icon = document.getElementById('placeholder-icon');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                icon.classList.add('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
@endsection