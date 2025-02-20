<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Tambahkan ini agar DB::statement() bisa digunakan

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Pastikan schema "transaction" sudah ada
        DB::statement('CREATE SCHEMA IF NOT EXISTS transaction;');

        // Buat tabel orders di dalam schema transaction
        Schema::create('transaction.orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->unique();
            $table->foreignId('customer_id')
                ->constrained('master_tables.customers') // Pastikan schema benar
                ->onDelete('cascade');
            $table->timestamp('order_date')->useCurrent();
            $table->softDeletes();
            $table->timestamps();
        });

        // Buat tabel order_product di dalam schema transaction
        Schema::create('transaction.order_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')
                ->constrained('transaction.orders') // Pastikan schema benar
                ->onDelete('cascade');
            $table->foreignId('product_id')
                ->constrained('master_tables.products') // Pastikan schema benar
                ->onDelete('cascade');
            $table->integer('quantity');
            $table->float('price');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction.order_product');
        Schema::dropIfExists('transaction.orders');
    }
};
