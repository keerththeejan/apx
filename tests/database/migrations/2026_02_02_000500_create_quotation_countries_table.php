<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('quotation_countries', function (Blueprint $table) {
            $table->id();
            $table->string('name', 120);
            $table->string('code', 20)->nullable();
            $table->decimal('rate_per_kg', 12, 2)->default(0);
            $table->decimal('base_fee', 12, 2)->nullable()->default(0);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quotation_countries');
    }
};
