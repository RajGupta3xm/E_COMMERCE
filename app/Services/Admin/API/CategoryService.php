<?php

namespace App\Services\Admin\API;

use App\Models\Category;

class CategoryService
{
    public function list(array $params)
    {
        $query = Category::with(['parent', 'children'])
            ->active()
            ->orderBy('order');

        if (isset($params['parent_id'])) {
            $query->where('parent_id', $params['parent_id']);
        } else {
            $query->whereNull('parent_id');
        }

        $perPage = $params['per_page'] ?? 15;

        return $query->paginate($perPage);
    }

    public function find(int $id)
    {
        return Category::with(['parent', 'children'])
            ->active()
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        return Category::create($data);
    }

    public function update(Category $category, array $data)
    {
        $category->update($data);
        return $category;
    }

    public function delete(Category $category)
    {
        if ($category->children()->exists()) {
            throw new \Exception('Cannot delete category with sub-categories.');
        }

        return $category->delete();
    }

    public function tree()
    {
        return Category::with(['children' => function ($q) {
                $q->active()->orderBy('order');
            }])
            ->whereNull('parent_id')
            ->active()
            ->orderBy('order')
            ->get();
    }

    public function search(string $query)
    {
        return Category::where(function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('description', 'LIKE', "%{$query}%");
            })
            ->active()
            ->limit(10)
            ->get();
    }
}
