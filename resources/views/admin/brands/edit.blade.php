@extends('layouts.admin')

@section('title', 'Edit Brand - ' . $brand->name)

@section('content')
<div class="py-6">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="md:flex md:items-center md:justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Edit Brand: {{ $brand->name }}</h2>
            <a href="{{ route('admin.brands.index') }}" class="text-sm text-blue-600 hover:underline">← Back to List</a>
        </div>

        <div class="bg-white shadow sm:rounded-lg overflow-hidden">
            <form action="{{ route('admin.brands.update', $brand) }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Brand Name</label>
                        <input type="text" name="name" value="{{ old('name', $brand->name) }}" 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Slug</label>
                        <input type="text" name="slug" value="{{ old('slug', $brand->slug) }}" 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-gray-50">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Brand Logo</label>
                        <div class="mt-2 flex items-center space-x-5">
                            <div class="h-20 w-20 border rounded-lg overflow-hidden bg-gray-50">
                                @if($brand->logo)
                                    <img src="{{ asset('storage/' . $brand->logo) }}" id="preview" class="h-full w-full object-contain p-1">
                                @else
                                    <div class="h-full w-full flex items-center justify-center text-gray-400 text-xs text-center">No Logo</div>
                                @endif
                            </div>
                            <input type="file" name="logo" onchange="previewImage(this)"
                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        </div>
                    </div>

                    <div class="flex space-x-8 mt-4">
                        <label class="flex items-center">
                            <input type="checkbox" name="is_active" value="1" {{ $brand->is_active ? 'checked' : '' }} 
                                   class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                            <span class="ml-2 text-sm text-gray-700 font-medium">Active</span>
                        </label>

                       
                    </div>
                </div>

                <div class="mt-8 pt-5 border-t border-gray-200">
                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Update Brand Details
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Image Preview function
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection