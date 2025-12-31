<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Clear existing data
        Category::truncate();
        
        // Create main categories
        $electronics = Category::create([
            'name' => 'Electronics',
            'slug' => 'electronics',
            'description' => 'Electronic devices and gadgets',
            'is_active' => true,
            'order' => 1,
        ]);

        $fashion = Category::create([
            'name' => 'Fashion',
            'slug' => 'fashion',
            'description' => 'Clothing and accessories',
            'is_active' => true,
            'order' => 2,
        ]);

        $home = Category::create([
            'name' => 'Home & Kitchen',
            'slug' => 'home-kitchen',
            'description' => 'Home appliances and kitchenware',
            'is_active' => true,
            'order' => 3,
        ]);

        // Create sub-categories for Electronics
        Category::create([
            'name' => 'Mobile Phones',
            'slug' => 'mobile-phones',
            'description' => 'Smartphones and feature phones',
            'parent_id' => $electronics->id,
            'is_active' => true,
            'order' => 1,
        ]);

        Category::create([
            'name' => 'Laptops',
            'slug' => 'laptops',
            'description' => 'Laptops and notebooks',
            'parent_id' => $electronics->id,
            'is_active' => true,
            'order' => 2,
        ]);

        Category::create([
            'name' => 'Headphones',
            'slug' => 'headphones',
            'description' => 'Audio headsets and earphones',
            'parent_id' => $electronics->id,
            'is_active' => true,
            'order' => 3,
        ]);

        // Create sub-categories for Fashion
        Category::create([
            'name' => "Men's Clothing",
            'slug' => 'mens-clothing',
            'description' => 'Clothing for men',
            'parent_id' => $fashion->id,
            'is_active' => true,
            'order' => 1,
        ]);

        Category::create([
            'name' => "Women's Clothing",
            'slug' => 'womens-clothing',
            'description' => 'Clothing for women',
            'parent_id' => $fashion->id,
            'is_active' => true,
            'order' => 2,
        ]);

        // Create sub-categories for Home & Kitchen
        Category::create([
            'name' => 'Furniture',
            'slug' => 'furniture',
            'description' => 'Home furniture',
            'parent_id' => $home->id,
            'is_active' => true,
            'order' => 1,
        ]);

        Category::create([
            'name' => 'Kitchen Appliances',
            'slug' => 'kitchen-appliances',
            'description' => 'Kitchen tools and appliances',
            'parent_id' => $home->id,
            'is_active' => true,
            'order' => 2,
        ]);

        $this->command->info('✅ Categories seeded successfully!');
    }
}
