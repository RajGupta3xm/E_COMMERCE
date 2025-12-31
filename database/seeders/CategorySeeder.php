<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // database/seeders/CategorySeeder.php
public function run()
{
    $categories = [
        [
            'name' => 'Electronics',
            'slug' => 'electronics',
            'description' => 'Electronic devices and gadgets',
            'is_active' => true,
            'order' => 1,
            'children' => [
                [
                    'name' => 'Mobile Phones',
                    'slug' => 'mobile-phones',
                    'description' => 'Smartphones and feature phones',
                    'order' => 1,
                ],
                [
                    'name' => 'Laptops',
                    'slug' => 'laptops',
                    'description' => 'Laptops and notebooks',
                    'order' => 2,
                ],
            ]
        ],
        [
            'name' => 'Fashion',
            'slug' => 'fashion',
            'description' => 'Clothing and accessories',
            'is_active' => true,
            'order' => 2,
        ]
    ];

    foreach ($categories as $categoryData) {
        $children = $categoryData['children'] ?? [];
        unset($categoryData['children']);
        
        $category = Category::create($categoryData);
        
        foreach ($children as $child) {
            $child['parent_id'] = $category->id;
            Category::create($child);
        }
    }
}
}
