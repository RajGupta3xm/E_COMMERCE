<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

use App\Services\CategoryService;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }
    public function index()
    {
        $categories = Category::paginate(10);
        $categoryCount = Category::count();

        return view('admin.categories.index', compact('categories', 'categoryCount'));
    }
    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name',
            'image' => 'nullable|image'
        ]);

        $this->categoryService->store($request);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category Created');
    }
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $this->categoryService->update($request, $category);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category Updated');
    }

    public function destroy(Category $category)
    {
        $this->categoryService->delete($category);

        return back()->with('success', 'Category Deleted');
    }
}

