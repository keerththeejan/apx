<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('features', function (Blueprint $table) {
            if (!Schema::hasColumn('features', 'icon_image_url')) {
                $table->string('icon_image_url')->nullable()->after('icon');
            }
            if (!Schema::hasColumn('features', 'is_visible')) {
                $table->boolean('is_visible')->default(true)->after('sort_order');
            }
        });
    }

    public function down(): void
    {
        Schema::table('features', function (Blueprint $table) {
            if (Schema::hasColumn('features', 'icon_image_url')) {
                $table->dropColumn('icon_image_url');
            }
            if (Schema::hasColumn('features', 'is_visible')) {
                $table->dropColumn('is_visible');
            }
        });
    }
};
