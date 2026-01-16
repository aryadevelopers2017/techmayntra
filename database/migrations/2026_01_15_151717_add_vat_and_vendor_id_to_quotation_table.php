<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVatAndVendorIdToQuotationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quotation', function (Blueprint $table) {
            // VAT flag (0 = no, 1 = yes)
            $table->tinyInteger('vat')
                  ->default(0)
                  ->after('gst');

            $table->bigInteger('v_id')->nullable();

            $table->text('trn_no')->nullable()->after('v_id');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quotation', function (Blueprint $table) {

            $table->dropColumn(['vat', 'v_id','trn_no']);
        });
    }
}
