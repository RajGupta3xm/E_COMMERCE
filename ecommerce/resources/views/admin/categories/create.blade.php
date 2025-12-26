@extends('layouts.admin')
@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-8 py-6 border-b border-gray-50 bg-gray-50/50">
            <h3 class="text-xl font-bold text-gray-800">Add New Category</h3>
            <p class="text-sm text-gray-500">Apne store ke liye ek nayi category create karein.</p>
        </div>

        <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data" class="p-8 space-y-6">
            @csrf

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Category Name</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                        <i class="fas fa-tag"></i>
                    </span>
                    <input type="text" name="name" 
                        class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition-all" 
                        placeholder="e.g. Electronics, Fashion..." required>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Category Thumbnail</label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:border-orange-400 transition-colors bg-gray-50">
                    <div class="space-y-1 text-center">
                        <i class="fas fa-cloud-upload-alt text-gray-400 text-3xl mb-2"></i>
                        <div class="flex text-sm text-gray-600">
                            <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-orange-600 hover:text-orange-500 focus-within:outline-none">
                                <span>Upload a file</span>
                                <input id="file-upload" name="image" type="file" class="sr-only" required>
                            </label>
                            <p class="pl-1">or drag and drop</p>
                        </div>
                        <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Visibility Status</label>
                <select name="status" 
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition-all appearance-none cursor-pointer">
                    <option value="1">✅ Active (Show on Store)</option>
                    <option value="0">❌ Inactive (Hide from Store)</option>
                </select>
            </div>

            <div class="pt-4 flex items-center justify-end space-x-4">
                <a href="{{ route('admin.categories.index') }}" class="text-sm font-semibold text-gray-500 hover:text-gray-700 transition-colors">Cancel</a>
                <button type="submit" 
                    class="px-8 py-3 bg-orange-500 hover:bg-orange-600 text-white font-bold rounded-xl shadow-lg shadow-orange-200 transition-all hover:-translate-y-0.5 active:scale-95">
                    Save Category
                </button>
            </div>
        </form>
    </div>
</div>
@endsection