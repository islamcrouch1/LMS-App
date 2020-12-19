<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomeWorksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('home_works', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('country_id');
            $table->integer('teacher_id')->nullable();
            $table->string('user_name');
            $table->string('teacher_name')->nullable();
            $table->integer('course_id')->nullable();
            $table->integer('home_work_order_id')->nullable();
            $table->string('homework_title')->nullable();
            $table->text('student_note')->nullable();
            $table->text('teacher_note')->nullable();
            $table->string('student_image')->nullable();
            $table->string('teacher_image')->default('#');
            $table->string('student_file')->nullable();
            $table->string('teacher_file')->default('#');
            $table->string('status')->default('waiting');
            $table->string('recieve_time')->nullable();
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
        Schema::dropIfExists('home_works');
    }
}
