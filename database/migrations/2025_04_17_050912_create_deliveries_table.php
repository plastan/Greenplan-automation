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
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('breakfast_assignment_id')->nullable()->constrained('customer_meal_assignments');
            $table->foreignId('lunch_assignment_id')->nullable()->constrained('customer_meal_assignments');
            $table->foreignId('dinner_assignment_id')->nullable()->constrained('customer_meal_assignments');
            $table->date('meal_date');
            $table->integer('cycle_number')->default(1);
            $table->integer('current_day')->default(1);
            $table->boolean('icepacks_returned')->default(True);
            $table->Text('special_note')->nullable();
            $table->Boolean('is_delivered')->default(False);
            $table->Timestamp('delivery_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deliveries');
    }
};
