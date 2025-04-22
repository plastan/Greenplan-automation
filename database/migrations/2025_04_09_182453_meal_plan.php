<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('meal_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->enum('type', ['muscle gain', 'weight loss', 'diabetic']);
            $table->boolean('breakfast')->default(true);
            $table->boolean('lunch')->default(true);
            $table->boolean('dinner')->default(true);
            $table->integer('cycle_number')->default(1);
            $table->integer('current_day')->default(1);
            $table->text('restrictions_note')->nullable();
            $table->text('special_instruction')->nullable();
            $table->string('veg_day')->nullable(); // Will store day of the week
            $table->timestamps();
        });       //

        DB::statement('ALTER TABLE meal_plans ADD CONSTRAINT check_current_day CHECK (current_day < 27)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meal_plans');
    }
};
