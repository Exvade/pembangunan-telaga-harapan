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
    Schema::create('expenses', function (Illuminate\Database\Schema\Blueprint $t) {
        $t->id();
        $t->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
        $t->date('date');                    // tanggal pengeluaran
        $t->string('description');           // contoh: Pembelian semen
        $t->string('unit_label')->nullable(); // contoh: "50 sak", "20 pcs"
        $t->unsignedBigInteger('amount');    // total pengeluaran (Rp)
        $t->string('attachment_path')->nullable(); // bukti (jpg/png/webp/pdf)
        $t->string('notes')->nullable();
        $t->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('expenses');
}

};
