@extends('layouts.admin')

@section('title', 'Edit Category')

@section('content')
<div class="max-w-4xl mx-auto pb-12">
    <nav class="flex mb-5 text-sm" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('admin.categories.index') }}" class="text-gray-500 hover:text-orange-600 transition-colors">Categories</a>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-300 text-xs mx-2"></i>
                    <span class="text-gray-400">Edit</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-8 py-6 border-b border-gray-50 bg-gradient-to-r from-gray-50 to-orange-50/30">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-2xl font-black text-gray-800 tracking-tight">Edit Category</h3>
                    <p class="text-sm text-gray-500 mt-1">Update details for <span class="font-bold text-orange-600">{{ $category->name }}</span></p>
                </div>
                <div class="flex items-center">
                    <span class="flex items-center px-4 py-1.5 rounded-full text-xs font-bold tracking-wider uppercase {{ $category->status ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        <span class="w-2 h-2 rounded-full mr-2 {{ $category->status ? 'bg-green-500' : 'bg-red-500' }}"></span>
                        {{ $category->status ? 'Active' : 'Inactive' }}
                    </span>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.categories.update', $category->id) }}" enctype="multipart/form-data" class="p-8 space-y-8">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">Category Name</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400 pointer-events-none">
                                <i class="fas fa-tag"></i>
                            </span>
                            <input type="text" name="name" id="category_name" value="{{ old('name', $category->name) }}"
                                class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border {{ $errors->has('name') ? 'border-red-400' : 'border-gray-200' }} rounded-2xl focus:ring-4 focus:ring-orange-500/10 focus:border-orange-500 outline-none transition-all font-medium" 
                                placeholder="e.g. Electronics" required>
                        </div>
                        @error('name') <p class="mt-2 text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">Slug (Auto-generated)</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                                <i class="fas fa-link text-xs"></i>
                            </span>
                            <input type="text" name="slug" id="category_slug" value="{{ old('slug', $category->slug) }}"
                                class="w-full pl-11 pr-4 py-3.5 bg-gray-100 border border-gray-200 rounded-2xl text-gray-500 cursor-not-allowed font-mono text-sm" 
                                readonly>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">Visibility Status</label>
                        <div class="relative">
                            <select name="status" 
                                class="w-full px-4 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-orange-500/10 focus:border-orange-500 outline-none transition-all appearance-none cursor-pointer font-medium">
                                <option value="1" {{ old('status', $category->status) == 1 ? 'selected' : '' }}>✅ Active - Visible to customers</option>
                                <option value="0" {{ old('status', $category->status) == 0 ? 'selected' : '' }}>❌ Inactive - Hidden from store</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-gray-400">
                                <i class="fas fa-chevron-down text-xs"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">Category Media</label>
                    
                    <div class="relative group aspect-video bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200 overflow-hidden flex items-center justify-center">
                        @if($category->image)
                            <img id="preview-image" src="{{ asset('storage/' . $category->image) }}" class="w-full h-full object-cover">
                        @else
                            <div id="no-image-placeholder" class="text-center">
                                <i class="fas fa-image text-gray-300 text-4xl mb-2"></i>
                                <p class="text-xs text-gray-400 font-medium">No Thumbnail Found</p>
                            </div>
                        @endif
                        
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                             <label for="file-upload" class="cursor-pointer bg-white text-gray-800 px-4 py-2 rounded-xl text-sm font-bold hover:bg-orange-500 hover:text-white transition-all">
                                Change Image
                             </label>
                        </div>
                    </div>

                    <div class="mt-4">
                        <input id="file-upload" name="image" type="file" class="hidden" accept="image/*">
                        <p class="text-[10px] text-gray-400 text-center italic">Supported: JPG, PNG, WEBP (Max: 2MB)</p>
                    </div>
                </div>
            </div>

            <div class="pt-8 border-t border-gray-50 flex flex-col sm:flex-row items-center justify-between gap-4">
               

                <div class="flex items-center space-x-4 w-full sm:w-auto">
                    <a href="{{ route('admin.categories.index') }}" class="flex-1 sm:flex-none text-center px-8 py-3.5 border border-gray-200 text-gray-600 font-bold rounded-2xl hover:bg-gray-50 transition-all">
                        Cancel
                    </a>
                    <button type="submit" class="flex-1 sm:flex-none px-10 py-3.5 bg-orange-500 hover:bg-orange-600 text-white font-black rounded-2xl shadow-xl shadow-orange-200 hover:shadow-orange-300 transition-all transform hover:-translate-y-1">
                        Save Changes
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Preview Image before upload
    document.getElementById('file-upload').onchange = evt => {
        const [file] = evt.target.files
        if (file) {
            const preview = document.getElementById('preview-image');
            if(preview) {
                preview.src = URL.createObjectURL(file)
            } else {
                // If placeholder was there, replace it
                location.reload(); // Simple way to handle first upload preview
            }
        }
    }

    // Auto-generate slug
    document.getElementById('category_name').addEventListener('input', function() {
        let text = this.value.toLowerCase()
            .replace(/[^\w\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/--+/g, '-')
            .trim();
        document.getElementById('category_slug').value = text;
    });

   
</script>
@endpush