<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceMaster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_master', function (Blueprint $table) {
            $table->id();
            $table->dateTime('entrydate');
            $table->string('title');
            $table->bigInteger('proforma_invoice_id');
            $table->bigInteger('c_id');
            $table->bigInteger('max_invoice_no');
            $table->string('invoice_no');
            $table->string('item_ids');
            $table->double('price', 15, 2);
            $table->double('remaining_amount', 15, 2);
            $table->double('payment_per', 15, 2);
            $table->double('taxable_amount', 15, 2);
            $table->double('gst_per', 15, 2);
            $table->double('gst_amount', 15, 2);
            $table->double('total_amount', 15, 2);
            $table->longText('bank_details');
            $table->bigInteger('status');
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
        Schema::dropIfExists('invoice_master');
    }
}
