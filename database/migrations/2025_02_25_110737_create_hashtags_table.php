<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Create hashtags table first
        Schema::create('hashtags', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->integer('posts_count')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hashtags');
    }
};
