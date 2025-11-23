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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            
            // This correctly links to your 'categories' table
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            
            // This correctly links to your 'conditions' table
            $table->foreignId('condition_id')->constrained('conditions')->onDelete('cascade');
            
            $table->integer('quantity');
            $table->string('location');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};

