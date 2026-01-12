<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'image' => $this->image ? asset('storage/' . $this->image) : null,
            'is_active' => (bool) $this->is_active, // Boolean cast for safety
            'parent_id' => $this->parent_id,
            'order' => $this->order,
            
            // Parent loading
            'parent' => $this->whenLoaded('parent', function () {
                return new CategoryResource($this->parent);
            }),

            // 🛠️ SMART FIX: Agar status=active filter hai, toh children bhi wahi dikhao
            'children' => CategoryResource::collection($this->whenLoaded('children', function() use ($request) {
                if ($request->query('status') === 'active') {
                    return $this->children->where('is_active', true);
                }
                return $this->children;
            })),

            'created_at' => $this->created_at->toISOString(),
            'updated_at' => $this->updated_at->toISOString(),
            '_links' => [
                'self' => route('api.categories.show', $this->id),
            ]
        ];
    }
}