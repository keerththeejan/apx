<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('home_banners')) {
            return;
        }
        if (Schema::hasColumn('home_banners', 'bg_image_urls')) {
            return;
        }
        Schema::table('home_banners', function (Blueprint $table) {
            $table->json('bg_image_urls')->nullable()->after('bg_image_url');
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('home_banners')) {
            return;
        }
        Schema::table('home_banners', function (Blueprint $table) {
            $table->dropColumn('bg_image_urls');
        });
    }
};
