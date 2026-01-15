<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPassengerAndServiceTypeToQuotationItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quotation_item', function (Blueprint $table) {
            $table->text('passenger_type')->nullable()->after('qty');
            $table->text('service_type')->nullable()->after('passenger_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('quotation_item', function (Blueprint $table) {
            $table->dropColumn(['passenger_type', 'service_type']);
        });
    }
}
