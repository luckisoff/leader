<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateLeaderBoardsUpdate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::table('leader_boards',function(Blueprint $table){
            $table->smallInteger('payment_claim')->default(0);
       });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('leader_boards',function(Blueprint $table){
            $table->dropColumn('payment_claim');
       });
    }
}
