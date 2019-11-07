<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateJudgesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('judges',function(Blueprint $table){
            $table->string('youtube_link')->nullable();
            $table->text('description');
            $table->string('type');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('judges', function (Blueprint $table) {
            $table->dropColumn('youtube_link');
            $table->dropColumn('description');
            $table->dropColumn('type');
        });
    }
}
