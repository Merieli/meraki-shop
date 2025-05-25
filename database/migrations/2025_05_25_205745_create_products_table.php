<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150)->unique();
            $table->integer('price');
            $table->integer('cost_price')->nullable();
            $table->integer('stock')->nullable();
            $table->text('thumbnail');
            $table->text('images');
            $table->string('short_description', 255);
            $table->text('description')->nullable();
            $table->smallInteger('rating');
            $table->string('sku', 50);
            $table->timestamps();
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
