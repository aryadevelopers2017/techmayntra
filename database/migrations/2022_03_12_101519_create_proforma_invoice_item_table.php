<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProformaInvoiceItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proforma_invoice_item', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('c_id');
            $table->bigInteger('proforma_invoice_id');
            $table->string('item_id');
            $table->longText('description');
            $table->double('price', 15, 2);
            $table->double('rate', 15, 2);
            $table->bigInteger('qty');
            $table->bigInteger('qty_id');
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
        Schema::dropIfExists('proforma_invoice_item');
    }
}
