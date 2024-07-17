<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('provider');
            $table->dropColumn('name');
            
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');

            $table->string('session_id');
            $table->string('session_payment_id');
            $table->string('customer_email');
            $table->string('session_payment_created');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::table('payments', function (Blueprint $table) {
            //
        });
    }
};
