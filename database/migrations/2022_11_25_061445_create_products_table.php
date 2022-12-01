<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->uuid('barcode')->unique();
            $table->string('name');

            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')
                ->on('categories');

            $table->string('brand');
            $table->double('price', 10, 4);
            $table->double('quantity', 10, 4);
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
