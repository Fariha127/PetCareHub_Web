<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('species');
            $table->string('breed')->nullable();
            $table->unsignedTinyInteger('age')->nullable();
            $table->string('gender');
            $table->string('vaccination_status')->default('Not Vaccinated');
            $table->string('adoption_status')->default('Available');
            $table->string('image_url')->nullable();
            $table->text('description')->nullable();
            $table->text('habits')->nullable();
            $table->text('food_preference')->nullable();
            $table->text('other_preferences')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pets');
    }
};
