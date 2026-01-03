<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_order', function (Blueprint $table) {
            $table->id();
            $table->date('purchase_date');
            $table->bigInteger('max_invoice_no')->nullable();
            $table->string('order_no');
            $table->string('company_name');
            $table->bigInteger('company_id')->nullable()->default(1);
            $table->bigInteger('vender_id');
            $table->string('project_id')->nullable();
            $table->string('subject')->nullable();
            $table->string('product_name');
            $table->longText('description');
            $table->longText('address');
            $table->string('city');
            $table->string('state');
            $table->string('pincode');
            $table->date('due_date');
            $table->integer('status');
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
        Schema::dropIfExists('purchase_order');
    }
}
