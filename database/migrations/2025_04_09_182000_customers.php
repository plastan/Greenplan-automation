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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('wa_number'); // WhatsApp number
            $table->string('subscription_status');
            $table->integer('age')->nullable();
            $table->string('email')->unique();
            $table->float('weight')->nullable(); // Assuming weight in kg
            $table->float('height')->nullable(); // Assuming height in cm
            $table->string('cycle')->nullable();
            $table->date('cycle_start_date')->nullable();
            $table->date('first_cycle_date')->nullable();
            $table->timestamps(); // This creates created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
