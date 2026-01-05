<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\Admin\API\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index(Request $request)
    {
        $categories = $this->categoryService->list($request->all());
        return new CategoryCollection($categories);
    }

    public function show($id)
    {
        $category = $this->categoryService->find($id);
        return new CategoryResource($category);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id'   => 'nullable|exists:categories,id',
            'order'       => 'integer|min:0',
            'is_active'   => 'boolean',
        ]);

        $category = $this->categoryService->store($validated);

        return new CategoryResource($category);
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'name'        => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'parent_id'   => 'nullable|exists:categories,id',
            'order'       => 'integer|min:0',
            'is_active'   => 'boolean',
        ]);

        $category = $this->categoryService->update($category, $validated);

        return new CategoryResource($category);
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        try {
            $this->categoryService->delete($category);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 422);
        }

        return response()->json([
            'message' => 'Category deleted successfully.'
        ]);
    }

    public function tree()
    {
        $categories = $this->categoryService->tree();
        return CategoryResource::collection($categories);
    }

    public function search(Request $request)
    {
        $request->validate([
            'q' => 'required|string'
        ]);

        $categories = $this->categoryService->search($request->q);

        return CategoryResource::collection($categories);
    }
}
