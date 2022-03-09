<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 120);
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('google_id')->nullable();
            $table->string('address', 200)->nullable();
            $table->string('location', 5)->default('vi');
            $table->unsignedBigInteger('group_id')->default('1');;
            $table->string('password')->nullable();
            $table->decimal('total_money')->nullable();
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
        Schema::dropIfExists('customers');
    }
}
