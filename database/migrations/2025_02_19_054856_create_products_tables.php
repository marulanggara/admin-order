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

        DB::statement('CREATE SCHEMA IF NOT EXISTS master_tables;');
        Schema::create('master_tables.products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('code')->unique();
            $table->string('description', 255);
            $table->integer('selling_price');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_tables.products');
    }
};
