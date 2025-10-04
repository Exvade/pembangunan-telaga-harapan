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
    Schema::dropIfExists('budgets');
}

public function down(): void
{
    // Optional: kalau ingin bisa rollback, buat ulang struktur minimal
    Schema::create('budgets', function (Illuminate\Database\Schema\Blueprint $t) {
        $t->id();
        $t->integer('year');
        $t->tinyInteger('month')->nullable();
        $t->string('category',100);
        $t->text('description')->nullable();
        $t->unsignedBigInteger('amount_planned')->default(0);
        $t->unsignedBigInteger('amount_realized')->default(0);
        $t->string('attachment_path')->nullable();
        $t->timestamps();
    });
}

};
