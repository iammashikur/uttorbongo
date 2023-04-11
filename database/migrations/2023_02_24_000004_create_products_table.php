<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('image')->nullable();
            $table->unsignedBigInteger('product_category_id');
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->unsignedBigInteger('seller_id')->nullable();
            $table->bigInteger('shop_id')->nullable();
            $table->unsignedBigInteger('brand_id');
            $table->decimal('purchase_price');
            $table->decimal('price');
            $table->text('details')->nullable();
            $table->string('product_type');
            $table->boolean('show_on_website')->default(1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
