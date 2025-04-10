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
        Schema::table('addresses', function (Blueprint $table) {
            $table->string("area")->nullable()->change();
            $table->string("building")->nullable()->change();
            $table->string("flat_number")->nullable()->change();
            $table->string("floor")->nullable()->change();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->string("area")->change();
            $table->string("building")->change();
            $table->string("flat_number")->change();
            $table->string("floor")->change();
        });

    }
};
