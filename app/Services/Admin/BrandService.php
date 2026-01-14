<?php
namespace App\Services\Admin;

use App\Models\Brand;
use Illuminate\Support\Facades\Storage;

class BrandService
{
    /**
     * Get Paginated and Filtered Brands
     */
    public function getBrands( $request, $isAjax = false)
    {
        $query = Brand::query();

        // Search Filter
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('slug', 'like', '%' . $request->search . '%');
            });
        }

        // Status Filter
        if ($request->filled('status')) {
            $query->where('is_active', $request->status);
        }

        $query->latest();

        // Agar AJAX hai toh pura data (search results ke liye), 
        // warna pagination (pehli baar page load ke liye)
        return $isAjax ? $query->get() : $query->paginate(20);
    }

    /**
     * Store or Update Brand Logic
     */
    public function storeOrUpdate(array $data, $brand = null)
    {
        if (isset($data['logo']) && $data['logo'] instanceof \Illuminate\Http\UploadedFile) {
            // Purana logo delete karein agar update ho raha hai
            if ($brand && $brand->logo) {
                Storage::disk('public')->delete($brand->logo);
            }
            $data['logo'] = $data['logo']->store('brands', 'public');
        }

        if ($brand) {
            $brand->update($data);
            return $brand;
        }

        return Brand::create($data);
    }

    /**
     * Delete Brand Logic
     */
    public function delete($id)
    {
        $brand = Brand::find($id);
        if ($brand) {
            if ($brand->logo) {
                Storage::disk('public')->delete($brand->logo);
            }
            return $brand->delete();
        }
        return false;
    }

    /**
     * Update Status Logic
     */
    public function updateStatus($id, $status)
    {
        $brand = Brand::findOrFail($id);
        $brand->is_active = $status;
        return $brand->save();
    }
}