<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('home_banners')) {
            return;
        }
        Schema::create('home_banners', function (Blueprint $table) {
            $table->id();
            $table->string('eyebrow')->nullable();
            $table->string('title_line1')->nullable();
            $table->string('title_line2')->nullable();
            $table->string('subtitle')->nullable();
            $table->text('bg_image_url')->nullable();
            $table->string('primary_text')->nullable();
            $table->string('primary_url')->nullable();
            $table->string('secondary_text')->nullable();
            $table->string('secondary_url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('home_banners');
    }
};
