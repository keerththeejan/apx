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
            if (!Schema::hasColumn('home_banners', 'banner_content_max_width_px')) {
                $table->unsignedInteger('banner_content_max_width_px')->nullable()->after('bg_position');
            }
            if (!Schema::hasColumn('home_banners', 'bg_size')) {
                $table->string('bg_size', 20)->nullable()->after('banner_content_max_width_px');
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('home_banners')) {
            return;
        }

        Schema::table('home_banners', function (Blueprint $table) {
            if (Schema::hasColumn('home_banners', 'bg_size')) {
                $table->dropColumn('bg_size');
            }
            if (Schema::hasColumn('home_banners', 'banner_content_max_width_px')) {
                $table->dropColumn('banner_content_max_width_px');
            }
        });
    }
};
