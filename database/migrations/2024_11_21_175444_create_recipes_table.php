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
        Schema::create('recipes', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->string('api_id')->unique();
            $table->string('name');
            $table->string('slug');
            $table->foreignUuid('recipe_category_id')->constrained('recipe_categories')->cascadeOnDelete();
            $table->foreignUuid('recipe_area_id')->constrained('recipe_areas')->cascadeOnDelete();
            $table->longText('instructions');
            $table->string('thumb');
            $table->string('video_url')->nullable();
            $table->json('ingredients');
            $table->string('source')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};
