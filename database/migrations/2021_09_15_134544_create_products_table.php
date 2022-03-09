<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->decimal('price')->nullable();
            $table->string('photo')->nullable();
            $table->text('description')->nullable();
            $table->text('color')->nullable();
            $table->text('barcode')->nullable();
            $table->text('product_code')->nullable();
            $table->unsignedInteger('category_id');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->decimal('import_price')->nullable();
            $table->integer('active')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
