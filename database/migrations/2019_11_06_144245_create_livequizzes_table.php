<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLivequizzesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('livequizzes', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('user_id')->nullable();
            $table->string('question_set')->nullable();
            $table->bigInteger('question_id')->nullable();
            $table->string('option')->nullable();
            $table->tinyInteger('answer')->default(0);
            $table->string('prize')->nullable();
            $table->bigInteger('point')->nullable();
            $table->bigInteger('time')->nullable();
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
        Schema::drop('livequizzes');
    }
}
