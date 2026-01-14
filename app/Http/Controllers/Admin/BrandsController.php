<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Http\Requests\Admin\BrandRequest;
use App\Services\Admin\BrandService;

class BrandsController extends Controller
{
    protected $brandService;

    public function __construct(BrandService $brandService)
    {
        $this->brandService = $brandService;
    }

    public function index(Request $request)
    {
        // Service ko call karein aur check karein ki AJAX hai ya nahi
        $brands = $this->brandService->getBrands($request, $request->ajax());

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'data' => $brands
            ]);
        }

        return view('admin.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('admin.brands.create');
    }

    public function store(BrandRequest $request)
    {
        $this->brandService->storeOrUpdate($request->validated());
        return redirect()->route('admin.brands.index')->with('success', 'Brand created successfully!');
    }

    public function edit(Brand $brand)
    {
        return view('admin.brands.edit', compact('brand'));
    }

    public function update(BrandRequest $request, Brand $brand)
    {
        try {
            $this->brandService->storeOrUpdate($request->validated(), $brand);
            return redirect()->route('admin.brands.index')->with('success', 'Brand updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $deleted = $this->brandService->delete($id);

        if (!$deleted) {
            return response()->json(['success' => false, 'message' => 'Brand not found!'], 404);
        }

        return response()->json(['success' => true, 'message' => 'Brand deleted successfully!']);
    }

    public function toggleStatus(Request $request)
    {
        $this->brandService->updateStatus($request->brand_id, $request->status);
        return response()->json(['success' => true, 'message' => 'Status Updated']);
    }
}