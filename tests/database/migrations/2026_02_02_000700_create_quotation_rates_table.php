<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('quotation_rates', function (Blueprint $table) {
            $table->id();
            $table->string('country', 120);
            $table->string('service', 120);
            $table->decimal('customer_price', 12, 2)->default(0);
            $table->decimal('dealer_price', 12, 2)->default(0);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quotation_rates');
    }
};
