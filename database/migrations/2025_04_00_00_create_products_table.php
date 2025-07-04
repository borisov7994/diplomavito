<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->string('image')->nullable();
        $table->string('name');       // Название товара
        $table->text('description'); // Описание
        $table->decimal('price', 8, 2); // Цена (например, 99999.99)
        $table->foreignId('user_id')->constrained();
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
