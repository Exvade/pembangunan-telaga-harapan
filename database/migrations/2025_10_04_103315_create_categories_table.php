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
    Schema::create('categories', function (Illuminate\Database\Schema\Blueprint $t) {
        $t->id();
        $t->string('name')->unique();
        $t->text('description')->nullable();
        $t->unsignedBigInteger('target_amount')->nullable(); // opsional target dana
        $t->boolean('is_active')->default(true);
        $t->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('categories');
}

};
