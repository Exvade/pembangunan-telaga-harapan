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
        Schema::table('incomes', function (Illuminate\Database\Schema\Blueprint $t) {
            // kalau FK sudah ada, drop dulu constraintnya, nama FK bisa berbeda tergantung versi
            try {
                $t->dropForeign(['category_id']);
            } catch (\Throwable $e) {
            }
            $t->foreignId('category_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('incomes', function (Illuminate\Database\Schema\Blueprint $t) {
            $t->foreignId('category_id')->nullable(false)->change();
            // opsional: tambahkan kembali FK
            $t->foreign('category_id')->references('id')->on('categories')->cascadeOnDelete();
        });
    }
};
