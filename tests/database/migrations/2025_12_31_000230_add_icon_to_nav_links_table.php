<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasColumn('nav_links', 'icon')) {
            Schema::table('nav_links', function (Blueprint $table) {
                $table->string('icon', 20)->nullable()->after('label');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('nav_links', 'icon')) {
            Schema::table('nav_links', function (Blueprint $table) {
                $table->dropColumn('icon');
            });
        }
    }
};
