<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryCollection extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        // Sirf data return karein, meta Laravel handle kar lega
        return [
            'data' => $this->collection,
        ];
    }

    /**
     * Isse pagination data clean single value mein aayega
     */
    public function paginationInformation($request, $paginated, $default)
    {
        return [
            'meta' => [
                'total'        => $paginated['total'],
                'count'        => count($paginated['data']),
                'per_page'     => $paginated['per_page'],
                'current_page' => $paginated['current_page'],
                'total_pages'  => $paginated['last_page'],
            ],
            'links' => $default['links']
        ];
    }
}