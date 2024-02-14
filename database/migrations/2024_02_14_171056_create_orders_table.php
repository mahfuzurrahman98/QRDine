<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('customer_name', 255);
            $table->string('customer_phone', 15);
            $table->json('items');
            $table->double('amount', 8, 2);
            $table->string('status', 20);
            $table->foreignId('restaurant_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('orders');
    }
};
