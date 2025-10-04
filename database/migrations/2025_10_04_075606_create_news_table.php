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
    Schema::create('news', function (Blueprint $t) {
        $t->id();
        $t->string('title');
        $t->string('slug')->unique();
        $t->string('cover_path')->nullable();
        $t->text('excerpt')->nullable();
        $t->longText('body');
        $t->enum('status', ['draft','published'])->default('draft');
        $t->timestamp('published_at')->nullable();
        $t->foreignId('author_id')->constrained('users')->cascadeOnDelete();
        $t->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('news');
}

};
