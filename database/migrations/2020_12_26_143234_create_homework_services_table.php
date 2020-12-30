<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomeworkServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('homework_services', function (Blueprint $table) {
            $table->id();
            $table->integer('country_id');
            $table->string('name_ar');
            $table->string('name_en');
            $table->string('description_ar');
            $table->string('description_en');
            $table->double('price' , 8 , 2);
            $table->double('teacher_commission' , 8 , 2);
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
        Schema::dropIfExists('homework_services');
    }
}
