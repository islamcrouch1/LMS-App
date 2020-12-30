<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomeWorkOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('home_work_orders', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('country_id');
            $table->integer('teacher_id')->nullable();
            $table->integer('course_id')->nullable();
            $table->integer('quantity')->nullable();
            $table->double('total_price' , 8 , 2);
            $table->double('wallet_balance' , 8 , 2);
            $table->string('orderid');
            $table->string('user_name');
            $table->string('teacher_name');
            $table->string('status');
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
        Schema::dropIfExists('home_work_orders');
    }
}
