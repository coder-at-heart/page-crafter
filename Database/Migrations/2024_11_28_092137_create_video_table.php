<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pagecraft_videos', function (Blueprint $table): void {
            $table->id();
            $table->char('provider');
            $table->string('code');
            $table->string('url')->index();
            $table->string('thumbnail')->nullable();
            $table->text('thumb_hash')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->integer('height')->nullable();
            $table->integer('width')->nullable();
            $table->timestamps();
            $table->unique(['provider', 'code']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pagecraft_videos');
    }
};
