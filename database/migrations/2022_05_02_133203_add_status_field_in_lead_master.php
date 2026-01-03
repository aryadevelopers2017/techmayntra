<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusFieldInLeadMaster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lead_master', function (Blueprint $table)
        {
            $table->integer('status')->after('follow_up_date')->comment('0 is pending, 1 = Accept, 2 = Reject');
            $table->text('remarks')->after('follow_up_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
}
