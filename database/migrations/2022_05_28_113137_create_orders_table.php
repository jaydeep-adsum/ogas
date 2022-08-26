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
            $table->dateTime('date');
            $table->enum('time_slot',[0,1,2,3]);
            $table->integer('total');
            $table->integer('driver_tip')->nullable();
            $table->unsignedInteger('customer_id');
            $table->enum('status',[0,1,2,3,4,5])->default(0);
            $table->unsignedInteger('driver_id')->nullable();
            $table->unsignedInteger('address_book_id')->nullable();
            $table->text('cancel_reason')->nullable();
            $table->timestamps();

            $table->foreign('address_book_id')->references('id')->on('address_books')
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
