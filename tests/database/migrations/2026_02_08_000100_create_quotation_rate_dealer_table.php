<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('quotation_rate_dealer', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quotation_rate_id');
            $table->unsignedBigInteger('dealer_id');
            $table->timestamps();

            $table->unique(['quotation_rate_id', 'dealer_id']);
            $table->foreign('quotation_rate_id')->references('id')->on('quotation_rates')->cascadeOnDelete();
            $table->foreign('dealer_id')->references('id')->on('dealers')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quotation_rate_dealer');
    }
};
