<?php

namespace App\Services\Admin\API;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

// class CategoryService
// {
//     public function list(array $params)
//     {
//         $query = Category::with(['parent', 'children'])
//             ->active()
//             ->orderBy('order');

//         if (isset($params['parent_id'])) {
//             $query->where('parent_id', $params['parent_id']);
//         } else {
//             $query->whereNull('parent_id');
//         }

//         $perPage = $params['per_page'] ?? 15;

//         return $query->paginate($perPage);
//     }

//     public function find(int $id)
//     {
//         return Category::with(['parent', 'children'])
//             ->active()
//             ->findOrFail($id);
//     }

//     public function store(array $data)
//     {
//         return Category::create($data);
//     }

//     public function update(Category $category, array $data)
//     {
//         $category->update($data);
//         return $category;
//     }

//     public function delete(Category $category)
//     {
//         if ($category->children()->exists()) {
//             throw new \Exception('Cannot delete category with sub-categories.');
//         }

//         return $category->delete();
//     }

//     public function tree()
//     {
//         return Category::with(['children' => function ($q) {
//                 $q->active()->orderBy('order');
//             }])
//             ->whereNull('parent_id')
//             ->active()
//             ->orderBy('order')
//             ->get();
//     }

//     public function search(string $query)
//     {
//         return Category::where(function ($q) use ($query) {
//                 $q->where('name', 'LIKE', "%{$query}%")
//                   ->orWhere('description', 'LIKE', "%{$query}%");
//             })
//             ->active()
//             ->limit(10)
//             ->get();
//     }
// }
class CategoryService
{
    /**
     * List categories with dynamic filters (Active/Inactive/Parents)
     */
    public function list(array $params)
    {
        $query = Category::with(['parent', 'children'])->orderBy('order', 'asc');

        // 1. Dynamic Status Filter (?status=active ya ?status=inactive)
        if (isset($params['status'])) {
            $status = ($params['status'] === 'active') ? 1 : 0;
            $query->where('is_active', $status);
        }

        // 2. Parent Filter (?parent_id=1)
        if (isset($params['parent_id'])) {
            $query->where('parent_id', $params['parent_id']);
        }

        // 3. Only Main Parents Filter (?only_parents=true)
        if (isset($params['only_parents']) && $params['only_parents'] == 'true') {
            $query->whereNull('parent_id');
        }

        $perPage = $params['per_page'] ?? 15;
        return $query->paginate($perPage);
    }

    /**
     * Find a single category (Admin can find inactive too)
     */
    public function find(int $id)
    {
        return Category::with(['parent', 'children'])->findOrFail($id);
    }

    /**
     * Store new category with Auto-Unique Slug
     */
    public function store(array $data)
    {
        // 🛑 Check if name already exists
        $exists = Category::where('name', $data['name'])->exists();

        if ($exists) {
            // Agar naam pehle se hai, toh error throw kar do
            throw new \Exception("Category name '{$data['name']}' alredy exists.");
        }

        $data['slug'] = Str::slug($data['name']);
        return Category::create($data);
    }

    /**
     * Update category
     */
    public function update(Category $category, array $data)
    {
        // 1. Agar naam change ho raha hai, toh check karein ki naya naam kisi aur ke paas toh nahi
        if (isset($data['name']) && $data['name'] !== $category->name) {

            $exists = Category::where('name', $data['name'])
                ->where('id', '!=', $category->id) // Apne aap ko chhod kar baaki sab mein check karo
                ->exists();

            if ($exists) {
                throw new \Exception("Category name '{$data['name']}' pehle se maujood hai.");
            }

            // Agar naam naya hai, toh naya slug bhi generate karein
            $data['slug'] = \Illuminate\Support\Str::slug($data['name']);
        }

        // 2. Data update karein
        $category->update($data);

        return $category;
    }

    /**
     * Delete category with check
     */
    public function delete(Category $category)
    {
        if ($category->children()->exists()) {
            throw new \Exception('Pehle sub-categories delete karein.');
        }

        return $category->delete();
    }

    /**
     * Complete Tree Structure (Full Hierarchy)
     */
    public function tree()
    {
        return Category::with([
            'children' => function ($q) {
                $q->orderBy('order', 'asc');
            }
        ])
            ->whereNull('parent_id')
            ->orderBy('order', 'asc')
            ->get();
    }

    /**
     * Search Categories
     */

    public function searchCategories($data)
    {
        $query = Category::query()->with('parent:id,name');

        if (!empty($data['q'])) {
            $query->where('name', 'LIKE', '%' . $data['q'] . '%');
        }

        if (isset($data['status']) && $data['status'] !== '') {
            $query->where('is_active', ($data['status'] === 'active' ? 1 : 0));
        }

        if (!empty($data['type'])) {
            $data['type'] === 'main' ? $query->whereNull('parent_id') : $query->whereNotNull('parent_id');
        }

        return $query->latest()->paginate(20)->appends(request()->query());
    }
}
