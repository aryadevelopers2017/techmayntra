<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateQuotationTableAddTermCondtionBankDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quotation', function (Blueprint $table)
        {
            $table->bigInteger('working_days');
            $table->longText('milestone');
            $table->bigInteger('terms_conditions_flag');
            $table->longText('terms_conditions');
            $table->bigInteger('payment_terms_conditions_flag');
            $table->longText('payment_terms_conditions');
            $table->bigInteger('bank_details_flag');
            $table->longText('bank_details');
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
