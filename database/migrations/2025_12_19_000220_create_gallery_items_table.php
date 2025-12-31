<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('gallery_items')) { return; }
        Schema::create('gallery_items', function (Blueprint $table) {
            $table->id();
            $table->string('image_url');
            $table->string('label')->nullable();
            $table->string('date_label', 24)->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gallery_items');
    }
};
