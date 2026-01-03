<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddQuotationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotation', function (Blueprint $table)
        {
            $table->id();
            $table->bigInteger('c_id');
            $table->string('invoice_no');
            $table->string('quotation_item_id');
            $table->double('price', 15, 2);
            $table->double('discount', 15, 2);
            $table->double('amount', 15, 2);
            $table->double('gst_per', 15, 2);
            $table->double('gst_amount', 15, 2);
            $table->double('total_amount', 15, 2);
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
        Schema::dropIfExists('quotation');
    }
}
