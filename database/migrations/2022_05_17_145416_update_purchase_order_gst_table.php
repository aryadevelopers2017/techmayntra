<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePurchaseOrderGstTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_order', function (Blueprint $table)
        {
            $table->decimal('amount', 10, 2)->nullable()->default(0);
            $table->integer('gst')->nullable()->default(0);
            $table->integer('igst')->nullable()->default(0);
            $table->decimal('gst_per', 10, 2)->nullable()->default(0);
            $table->decimal('gst_amount', 10, 2)->nullable()->default(0);
            $table->decimal('total_amount', 10, 2)->nullable()->default(0);
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
