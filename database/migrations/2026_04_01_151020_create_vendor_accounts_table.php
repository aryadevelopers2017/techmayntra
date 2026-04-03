<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_accounts', function (Blueprint $table) {
            $table->id();

            // FK → vendor table
            $table->unsignedBigInteger('vendor_id')->nullable();

            $table->string('order_no')->unique();
            $table->date('date');

            $table->string('company_name')->nullable();

            $table->text('address')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('state_id')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();

            $table->longText('description')->nullable();

            $table->string('status')->default('pending');

            $table->integer('total_amount')->default(0);

            $table->string('payment_mode')->nullable();

            $table->timestamps();

            // Optional foreign keys (only if tables exist)


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendor_accounts');
    }
}
