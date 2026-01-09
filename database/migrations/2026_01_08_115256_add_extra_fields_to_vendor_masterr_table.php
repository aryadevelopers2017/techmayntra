<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraFieldsToVendorMasterrTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vendor_master', function (Blueprint $table) {


            $table->string('country')->nullable()->after('address');

            // Service & Rate
            $table->unsignedBigInteger('service_id')->nullable()->after('city');
            $table->string('rate_option', 50)->nullable()->after('service_id');

            // Bank Details
            $table->string('bank_name')->nullable()->after('rate_option');
            $table->string('account_holder_name')->nullable()->after('bank_name');
            $table->string('account_number')->nullable()->after('account_holder_name');
            $table->string('ifsc_code', 20)->nullable()->after('account_number');
            $table->string('branch_name')->nullable()->after('ifsc_code');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vendor_masterr', function (Blueprint $table) {
            //
        });
    }
}
