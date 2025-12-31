<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CategoryCollection;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::with(['parent', 'children'])
            ->active()
            ->orderBy('order');
        
        // Filter by parent
        if ($request->has('parent_id')) {
            $query->where('parent_id', $request->parent_id);
        } else {
            $query->whereNull('parent_id');
        }
        
        // Pagination
        $perPage = $request->get('per_page', 15);
        $categories = $query->paginate($perPage);
        
        return new CategoryCollection($categories);
    }

    public function show($id)
    {
        $category = Category::with(['parent', 'children'])
            ->active()
            ->findOrFail($id);
        
        return new CategoryResource($category);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
            'order' => 'integer|min:0',
            'is_active' => 'boolean'
        ]);

        $category = Category::create($validated);

        return new CategoryResource($category);
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
            'order' => 'integer|min:0',
            'is_active' => 'boolean'
        ]);

        $category->update($validated);

        return new CategoryResource($category);
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        
        // Check if category has children
        if ($category->children()->exists()) {
            return response()->json([
                'message' => 'Cannot delete category with sub-categories.'
            ], 422);
        }
        
        $category->delete();

        return response()->json([
            'message' => 'Category deleted successfully.'
        ]);
    }

    // Get all categories in tree structure
    public function tree()
    {
        $categories = Category::with(['children' => function($query) {
            $query->active()->orderBy('order');
        }])
        ->whereNull('parent_id')
        ->active()
        ->orderBy('order')
        ->get();
        
        return CategoryResource::collection($categories);
    }

    // Search categories
    public function search(Request $request)
    {
        $query = $request->get('q');
        
        $categories = Category::where('name', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->active()
            ->limit(10)
            ->get();
        
        return CategoryResource::collection($categories);
    }
}