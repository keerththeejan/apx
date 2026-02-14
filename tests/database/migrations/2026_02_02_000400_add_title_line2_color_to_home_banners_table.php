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
            if (!Schema::hasColumn('home_banners', 'title_line2_color')) {
                $table->string('title_line2_color', 20)->nullable()->after('title_color');
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('home_banners')) {
            return;
        }

        Schema::table('home_banners', function (Blueprint $table) {
            if (Schema::hasColumn('home_banners', 'title_line2_color')) {
                $table->dropColumn('title_line2_color');
            }
        });
    }
};
