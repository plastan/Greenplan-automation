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
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->date("week_start_date");
            $table->string("name");
            $table->string("description");
            $table->enum("category",["breakfast", "lunch", "dinner"]);
            $table->enum("dietary_type",["diabetic", "muscle gain", "weight loss"]);
            $table->float('calories')->nullable();
            $table->float('fat')->nullable();
            $table->float('carbs')->nullable();
            $table->float('protein')->nullable();
            $table->timestamps();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};
