<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vet_checkups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pet_id')->constrained()->cascadeOnDelete();
            $table->foreignId('vet_id')->constrained('users')->cascadeOnDelete();
            $table->date('checkup_date');
            $table->decimal('weight', 6, 2)->nullable();
            $table->decimal('temperature', 5, 2)->nullable();
            $table->string('diagnosis')->nullable();
            $table->text('treatment')->nullable();
            $table->date('next_checkup_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vet_checkups');
    }
};
