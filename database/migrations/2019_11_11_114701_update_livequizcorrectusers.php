<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateLivequizcorrectusers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('live_quiz_correct_users',function(Blueprint $table){
            $table->tinyInteger('live_paid')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('live_quiz_correct_users',function(Blueprint $table){
            $table->dropColumn('live_paid');
        });
    }
}
