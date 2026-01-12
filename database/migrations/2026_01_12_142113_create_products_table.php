<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Example: iPhone 15, Poco X5
            $table->string('slug')->unique();

            // Aapki Categories Table se link (Mobile)
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');

            // Brands Table se link (Apple/Poco)
            $table->foreignId('brand_id')->constrained('brands')->onDelete('cascade');

            $table->decimal('price', 12, 2);
            $table->integer('stock')->default(0);
            $table->string('thumbnail')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
