<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('payment_id')->nullable()->constrained()->cascadeOnDelete();
            $table->dropColumn('dinein_table_id');
            $table->foreignId('dinein_table_id')->change()->nullable()->constrained()->cascadeOnDelete();
            $table->integer('status')->change()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
};
