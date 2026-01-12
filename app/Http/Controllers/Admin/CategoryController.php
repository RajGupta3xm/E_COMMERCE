<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\Admin\CategoryService;
use Illuminate\Http\Request;
use App\Jobs\ImportCategoriesCsvJob;

class CategoryController extends Controller
{
    protected CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * List categories
     */
    public function index()
    {
        $categories = $this->categoryService->getPaginatedCategories();
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        $parentCategories = $this->categoryService->getParentCategories();
        return view('admin.categories.create', compact('parentCategories'));
    }

    /**
     * Store category
     */
    public function store(Request $request)
    {
        $validated = $this->validateCategory($request);

        $this->categoryService->store($validated);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category created successfully.');
    }
    public function show(Category $category)
    {
        //
    }

    /**
     * Show edit form
     */
    public function edit(Category $category)
    {
        $parentCategories = $this->categoryService->getParentCategories($category->id);

        return view('admin.categories.edit', compact('category', 'parentCategories'));
    }

    /**
     * Update category
     */
    public function update(Request $request, Category $category)
    {
        $validated = $this->validateCategory($request);

        $this->categoryService->update($category, $validated);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    /**
     * Delete category
     */
    public function destroy(Category $category)
    {
        try {
            $this->categoryService->delete($category);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category deleted successfully.');
    }

    /**
     * Update category order (AJAX)
     */
    public function updateOrder(Request $request)
    {
        $this->categoryService->updateOrder($request->order ?? []);
        return response()->json(['success' => true]);
    }

    /**
     * Validation
     */
    private function validateCategory(Request $request): array
    {
        return $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id'   => 'nullable|exists:categories,id',
            'order'       => 'nullable|integer|min:0',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active'   => 'nullable|boolean',
        ]);
    }
    public function importForm()
    {
        // dd( 'import form');
        return view('admin.categories.import');
    }
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt|max:20480'
        ]);

        // store file
        $path = $request->file('file')->store('imports/categories');

        // dispatch job
        ImportCategoriesCsvJob::dispatch($path);
        // dd('job dispatched');

        return back()->with('success', 'CSV import started in background.');
    }
}