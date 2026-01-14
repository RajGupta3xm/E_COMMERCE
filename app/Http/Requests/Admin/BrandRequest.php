<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BrandRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $brandId = $this->route('brand')->id ?? null; // Edit ke waqt ID nikalne ke liye

        return [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:brands,slug,' . $brandId,
            'is_active' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ];
    }
}
