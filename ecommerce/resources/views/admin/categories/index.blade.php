@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-900">Categories List</h1>
            <p class="text-sm text-gray-500 mt-1">Apne store ki sabhi categories ko yahan se manage karein.</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="bg-orange-500 hover:bg-orange-600 text-white px-5 py-2.5 rounded-xl font-bold transition-all shadow-lg shadow-orange-200 flex items-center">
            <i class="fas fa-plus mr-2 text-sm"></i> Add New Category
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        
        <div class="p-4 border-b border-gray-50 bg-gray-50/30 flex justify-between items-center">
            <div class="relative w-72">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                    <i class="fas fa-search"></i>
                </span>
                <input type="text" placeholder="Search category..." class="w-full pl-10 pr-4 py-2 bg-white border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-orange-500 outline-none">
            </div>
            <div class="flex space-x-2">
                <button class="px-3 py-2 bg-white border border-gray-200 rounded-lg text-gray-600 text-sm hover:bg-gray-50"><i class="fas fa-filter mr-1"></i> Filter</button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 text-gray-400 uppercase text-[11px] font-bold tracking-wider">
                        <th class="px-6 py-4">Image</th>
                        <th class="px-6 py-4">Category Name</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-center">Total Products</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($categories as $category)
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="h-12 w-12 rounded-lg overflow-hidden border border-gray-100 shadow-sm bg-gray-50">
                                @if($category->image)
                                    <img src="{{ asset('storage/' . $category->image) }}" class="h-full w-full object-cover">
                                @else
                                    <div class="h-full w-full flex items-center justify-center text-gray-300">
                                        <i class="fas fa-image"></i>
                                    </div>
                                @endif
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-gray-800">{{ $category->name }}</div>
                            <div class="text-xs text-gray-400">Slug: {{ Str::slug($category->name) }}</div>
                        </td>

                        <td class="px-6 py-4 text-center">
                            @if($category->status == 1)
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-[10px] font-bold uppercase tracking-wide">Active</span>
                            @else
                                <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-[10px] font-bold uppercase tracking-wide">Inactive</span>
                            @endif
                        </td>

                        <td class="px-6 py-4 text-center font-semibold text-gray-600 text-sm">
                            {{ $category->products_count ?? 0 }}
                        </td>

                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end space-x-2">
                                <a href="{{ route('admin.categories.edit', $category->id) }}" class="p-2 text-blue-500 hover:bg-blue-50 rounded-lg transition" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-400">
                            <i class="fas fa-folder-open text-4xl mb-3"></i>
                            <p>Koi category nahi mili.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
            {{ $categories->links() }}
        </div>
    </div>
</div>
@endsection