<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAuditionTableRegistrationCodeSentCount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('audition_registration', function (Blueprint $table) {
            $table->integer('registration_code_send_count')->default(0);
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
            $table->dropColumn('registration_code_send_count');
        });
    }
}
