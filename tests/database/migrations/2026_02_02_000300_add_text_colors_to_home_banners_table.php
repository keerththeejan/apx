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
            if (!Schema::hasColumn('home_banners', 'eyebrow_color')) {
                $table->string('eyebrow_color', 20)->nullable()->after('eyebrow');
            }
            if (!Schema::hasColumn('home_banners', 'title_color')) {
                $table->string('title_color', 20)->nullable()->after('title_line2');
            }
            if (!Schema::hasColumn('home_banners', 'subtitle_color')) {
                $table->string('subtitle_color', 20)->nullable()->after('subtitle');
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('home_banners')) {
            return;
        }

        Schema::table('home_banners', function (Blueprint $table) {
            if (Schema::hasColumn('home_banners', 'subtitle_color')) {
                $table->dropColumn('subtitle_color');
            }
            if (Schema::hasColumn('home_banners', 'title_color')) {
                $table->dropColumn('title_color');
            }
            if (Schema::hasColumn('home_banners', 'eyebrow_color')) {
                $table->dropColumn('eyebrow_color');
            }
        });
    }
};
