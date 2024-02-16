<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table('restaurants', function (Blueprint $table) {
            $table->boolean('enable_wa_notification')->default(false);
            $table->string('currency')->default('GBP');
            $table->double('minimum_order_amount')->default(0);
            $table->boolean('active')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::table('restaurants', function (Blueprint $table) {
            //
        });
    }
};
