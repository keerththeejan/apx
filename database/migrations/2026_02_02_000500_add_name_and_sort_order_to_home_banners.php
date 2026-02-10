<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('home_banners', function (Blueprint $table) {
            if (!Schema::hasColumn('home_banners', 'name')) {
                $table->string('name')->nullable()->after('id');
            }
            if (!Schema::hasColumn('home_banners', 'sort_order')) {
                $table->unsignedInteger('sort_order')->default(0)->after('id');
            }
        });
        \DB::table('home_banners')->orderBy('id')->get()->each(function ($row, $i) {
            \DB::table('home_banners')->where('id', $row->id)->update(['sort_order' => $i]);
        });
    }

    public function down(): void
    {
        Schema::table('home_banners', function (Blueprint $table) {
            if (Schema::hasColumn('home_banners', 'name')) {
                $table->dropColumn('name');
            }
            if (Schema::hasColumn('home_banners', 'sort_order')) {
                $table->dropColumn('sort_order');
            }
        });
    }
};
