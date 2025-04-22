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
        Schema::create('customer_meal_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers');
            $table->foreignId('menu_item_id')->constrained('menu_items');
            $table->enum("delivery_status", ["delivered", "preparing", "delivering", "cancelled"]);
            $table->timestamp('meal_date');
            $table->timestamps();
        });
        // constrain uniqueness of meal_date,customer_id,menu_item_id
        Schema::table('customer_meal_assignments', function (Blueprint $table) {
            $table->unique(['meal_date', 'customer_id', 'menu_item_id']);
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_meal_assignments');
    }
};
