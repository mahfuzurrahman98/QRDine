<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->string('name', 255);
            $table->text('description')->nullable();
            $table->double('price', 8, 2);
            $table->string('image', 255)->nullable();
            $table->foreignId('category_id')->constrained();
            $table->boolean('out_of_stock')->default(false);
            $table->smallInteger('order_index')->default(0);
            $table->boolean('featured')->default(false);
            $table->boolean('active')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('items');
    }
};
