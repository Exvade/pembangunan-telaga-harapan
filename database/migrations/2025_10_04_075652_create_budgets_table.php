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
    Schema::create('budgets', function (Blueprint $t) {
        $t->id();
        $t->integer('year');
        $t->tinyInteger('month')->nullable(); // 1-12, null = tahunan
        $t->string('category', 100);
        $t->text('description')->nullable();
        $t->unsignedBigInteger('amount_planned')->default(0);
        $t->unsignedBigInteger('amount_realized')->default(0);
        $t->string('attachment_path')->nullable(); // bukti
        $t->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('budgets');
}

};
