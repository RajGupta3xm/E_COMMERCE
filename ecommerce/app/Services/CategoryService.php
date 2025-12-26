<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryService
{
    public function store($request)
    {
        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->image->store('categories', 'public');
        }

        return Category::create([
            'name'   => $request->name,
            'slug'   => Str::slug($request->name),
            'image'  => $imagePath,
            'status' => $request->status ?? 1
        ]);
    }

    public function update($request, Category $category)
    {
        $imagePath = $category->image;

        if ($request->hasFile('image')) {
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $request->image->store('categories', 'public');
        }

        $category->update([
            'name'   => $request->name,
            'slug'   => Str::slug($request->name),
            'image'  => $imagePath,
            'status' => $request->status
        ]);

        return $category;
    }

    public function delete(Category $category)
    {
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        return $category->delete();
    }
}
