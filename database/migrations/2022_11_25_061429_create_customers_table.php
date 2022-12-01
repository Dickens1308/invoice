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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->default('admin');
            $table->string('last_name')->default('shopify');
            $table->string('email')->default('admin.shopify@shopify.com');
            $table->string('phone_number')->default('shopify');
            $table->string('gender')->default('shopify');
            $table->string('home_address')->default('shopify');
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
        Schema::dropIfExists('customers');
    }
};
