<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('news_media', function (Blueprint $t) {
            $t->id();
            $t->foreignId('news_id')->constrained('news')->cascadeOnDelete();

            $t->string('type', 20); // image | video | file
            $t->string('file_path')->nullable();   // untuk image/file/video-upload
            $t->string('thumb_path')->nullable();  // opsional (thumbnail)
            $t->string('mime_type')->nullable();

            $t->string('embed_url')->nullable();   // untuk video embed (youtube/vimeo)
            $t->string('caption')->nullable();
            $t->string('credit')->nullable();

            $t->date('taken_at')->nullable();
            $t->string('location')->nullable();

            $t->integer('sort_order')->default(0);
            $t->boolean('is_featured')->default(false);

            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news_media');
    }
};
