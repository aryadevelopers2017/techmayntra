<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CompanyAddresss extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_address_master', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('company_id');
            $table->text('address');
            $table->string('city');
            $table->string('state');
            $table->integer('status')->comment('0 => Active, 1=>In-Active');
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
        //
    }
}
