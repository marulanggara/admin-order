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
        Schema::create('master_tables.customers', function (Blueprint $table) {
            $table->id();
            $table->string('no_customer')->unique();
            $table->string('name', 255);
            $table->string('email', 255)->unique();
            $table->string('phone');
            $table->string('address', 255); 
            $table->softDeletes();           
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_tables.customers');
    }
};
