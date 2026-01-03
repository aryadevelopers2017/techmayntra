<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('quotation_id');
            $table->string('quotation_title');
            $table->double('quotation_price', 15, 2);
            $table->bigInteger('customer_id');
            $table->bigInteger('vendor_id');
            $table->double('vendor_price', 15, 2);
            $table->date('start_date');
            $table->date('end_date');
            $table->longText('remarks')->nullable();
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('project');
    }
}
