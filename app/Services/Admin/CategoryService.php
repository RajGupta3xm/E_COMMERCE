<?php

namespace App\Services\Admin;

use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryService
{
    public function getPaginatedCategories()
    {
        return Category::with(['parent', 'children'])
            ->withCount('children')
            ->orderBy('order')
            ->paginate(20);
    }

    public function getParentCategories($excludeId = null)
    {
        return Category::whereNull('parent_id')
            ->when($excludeId, fn($q) => $q->where('id', '!=', $excludeId))
            ->get();
    }

    public function store(array $data)
    {
        // 1. Duplicate Name Check
        if (Category::where('name', $data['name'])->exists()) {
            throw new \Exception("Category '{$data['name']}' pehle se maujood hai.");
        }

        // 2. Image Handling
        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            $data['image'] = $data['image']->store('categories', 'public');
        }

        // 3. Slug Generation
        $data['slug'] = \Illuminate\Support\Str::slug($data['name']);

        return Category::create($data);
    }

    public function update(Category $category, array $data)
    {
        // 1. Unique Name Check (Apne ID ko chhod kar)
        if (isset($data['name']) && $data['name'] !== $category->name) {
            $exists = Category::where('name', $data['name'])
                ->where('id', '!=', $category->id)
                ->exists();

            if ($exists) {
                throw new \Exception("Category name '{$data['name']}' kisi aur category ne use kiya hua hai.");
            }

            $data['slug'] = \Illuminate\Support\Str::slug($data['name']);
        }

        // 2. Image Update Logic
        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            // Purani image delete karein agar exist karti hai
            if ($category->image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($category->image);
            }
            $data['image'] = $data['image']->store('categories', 'public');
        }

        $category->update($data);
        return $category;
    }

    public function delete(Category $category)
    {
        if ($category->children()->count() > 0) {
            throw new \Exception('Cannot delete category with sub-categories.');
        }

        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        return $category->delete();
    }

    public function updateOrder(array $order)
    {
        foreach ($order as $position => $id) {
            Category::where('id', $id)->update(['order' => $position]);
        }
    }
}
