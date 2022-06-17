<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->text('location');
            $table->integer('quantity');
            $table->date('date');
            $table->enum('time_slot',[0,1,2,3]);
            $table->enum('type',[1,2]);
            $table->integer('total');
            $table->integer('driver_tip')->nullable();
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('customer_id');
//            $table->unsignedInteger('driver_id');
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('customers')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}