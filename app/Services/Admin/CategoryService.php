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
            ->when($excludeId, fn ($q) => $q->where('id', '!=', $excludeId))
            ->get();
    }

    public function store(array $data)
    {
        if (isset($data['image'])) {
            $data['image'] = $data['image']->store('categories', 'public');
        }

        $data['slug'] = Str::slug($data['name']);

        return Category::create($data);
    }

    public function update(Category $category, array $data)
    {
        if (isset($data['image'])) {
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $data['image'] = $data['image']->store('categories', 'public');
        }

        if ($category->name !== $data['name']) {
            $data['slug'] = Str::slug($data['name']);
        }

        return $category->update($data);
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
