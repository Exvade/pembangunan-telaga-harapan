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
    Schema::create('incomes', function (Illuminate\Database\Schema\Blueprint $t) {
        $t->id();
        $t->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
        $t->date('date');                     // tanggal diterima
        $t->string('source')->nullable();     // Donatur A / Donasi Umum (opsional)
        $t->unsignedBigInteger('amount');     // nominal pemasukan (Rp)
        $t->string('attachment_path')->nullable(); // bukti (jpg/png/webp/pdf)
        $t->string('notes')->nullable();
        $t->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('incomes');
}

};
