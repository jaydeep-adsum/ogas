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
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->integer('quantity1')->nullable();
            $table->integer('quantity2')->nullable();
            $table->date('date');
            $table->enum('time_slot',[0,1,2,3]);
            $table->enum('type1',[1,2])->nullable();
            $table->enum('type2',[1,2])->nullable();
            $table->integer('total');
            $table->integer('driver_tip')->nullable();
            $table->unsignedInteger('product1_id')->nullable();
            $table->unsignedInteger('product2_id')->nullable();
            $table->unsignedInteger('customer_id');
            $table->unsignedInteger('driver_id')->nullable();
            $table->text('cancel_reason')->nullable();
            $table->timestamps();

            $table->foreign('product1_id')->references('id')->on('products')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('product2_id')->references('id')->on('products')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('customers')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('driver_id')->references('id')->on('drivers')
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
