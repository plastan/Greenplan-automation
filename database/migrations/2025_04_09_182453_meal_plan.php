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
    Schema::create('meal_plans', function (Blueprint $table) {
                $table->id();
                $table->enum('type', ['muscle gain', 'weight loss', 'diabetic']);
                $table->boolean('breakfast')->default(true);
                $table->boolean('lunch')->default(true);
                $table->boolean('dinner')->default(true);
                $table->text('restrictions_note')->nullable();
                $table->text('special_instruction')->nullable();
                $table->string('veg_day')->nullable(); // Will store day of the week
                $table->timestamps();
        });       //
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meal_plans');
    }
};
