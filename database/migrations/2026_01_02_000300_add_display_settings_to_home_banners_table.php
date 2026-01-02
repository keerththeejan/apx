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

        Schema::table('home_banners', function (Blueprint $table) {
            if (!Schema::hasColumn('home_banners', 'banner_height_px')) {
                $table->unsignedInteger('banner_height_px')->nullable()->after('bg_image_url');
            }
            if (!Schema::hasColumn('home_banners', 'bg_position')) {
                $table->string('bg_position', 30)->nullable()->after('banner_height_px');
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('home_banners')) {
            return;
        }

        Schema::table('home_banners', function (Blueprint $table) {
            if (Schema::hasColumn('home_banners', 'bg_position')) {
                $table->dropColumn('bg_position');
            }
            if (Schema::hasColumn('home_banners', 'banner_height_px')) {
                $table->dropColumn('banner_height_px');
            }
        });
    }
};
