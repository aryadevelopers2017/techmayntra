<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceItemMaster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_item_master', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('c_id');
            $table->bigInteger('invoice_id');
            $table->string('item_id');
            $table->longText('description');
            $table->double('price', 15, 2);
            $table->double('rate', 15, 2);
            $table->bigInteger('qty');
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
        Schema::dropIfExists('invoice_item_master');
    }
}
