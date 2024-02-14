<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('restaurants', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name', 255);
            $table->string('slug', 50)->unique();
            $table->string('description', 255);
            $table->string('address', 255);
            $table->string('phone', 15)->unique()->nullable();
            $table->string('logo', 255)->nullable();
            $table->string('cover', 255)->nullable();
            $table->boolean('enable_ordering')->default(false);
            $table->string('stripe_id', 255)->nullable();
            $table->foreignId('user_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('restaurants');
    }
};
