<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->string('purchase_id');
            $table->string('title')->nullable();
            $table->decimal('money',30,3)->default(0);
            $table->boolean('status')->default(0);
            $table->string('place_order')->nullable();
            $table->integer('stock_id');
            $table->boolean('paid')->default(0);
            $table->timestamps();
        });

        Schema::create('purchases_products', function (Blueprint $table) {
            $table->id();
            $table->string('purchase_id');
            $table->string('product_id');
            $table->integer('quantity');
            $table->decimal('money',13,3);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchases');
        Schema::dropIfExists('purchases_products');
    }
}
