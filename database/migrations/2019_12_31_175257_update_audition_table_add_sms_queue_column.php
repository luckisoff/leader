<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAuditionTableAddSmsQueueColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('audition_registration', function (Blueprint $table) {
            $table->integer('sms_queue')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('audition_registration', function (Blueprint $table) {
            $table->dropColumn('sms_queue');
        });
    }
}
