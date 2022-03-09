<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->string('title',255);
            $table->text('description')->nullable();
            $table->unsignedInteger('store_send');
            $table->unsignedInteger('store_take');
            $table->boolean('status')->default(0);
            $table->timestamps();
        });

        Schema::create('transfer_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('transfer_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedInteger('quantity');
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
        Schema::dropIfExists('transfers');
        Schema::dropIfExists('transfer_products');
    }
}
