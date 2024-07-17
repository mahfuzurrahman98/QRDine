<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('coupon_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id');
            $table->foreignId('coupon_id');
            $table->tinyInteger('coupon_type');
            $table->string('coupon_code');
            $table->double('amount');
            $table->double('discount');
            $table->timestamps();

            // one order can have one coupon, os order_id is unique
            $table->unique(['order_id', 'coupon_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('coupon_orders');
    }
};
