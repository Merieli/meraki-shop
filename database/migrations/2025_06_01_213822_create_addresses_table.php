<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('label', 20);
            $table->string('recipient_name', 100);
            $table->string('street', 150);
            $table->string('number', 20)->nullable();
            $table->string('neighborhood', 80);
            $table->string('complement', 50)->nullable();
            $table->string('city', 80);
            $table->string('state', 50);
            $table->string('country', 80);
            $table->string('postal_code', 20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('address');
    }
};
