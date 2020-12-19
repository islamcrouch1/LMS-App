<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->text('description_en')->nullable();
            $table->text('description_ar')->nullable();
            $table->text('study_plan')->nullable();
            $table->integer('status')->default(0);
            $table->string('image')->nullable();
            $table->integer('percent')->default(0);
            $table->string('path')->nullable();
            $table->float('average')->default(0);
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
        Schema::dropIfExists('teachers');
    }
}
