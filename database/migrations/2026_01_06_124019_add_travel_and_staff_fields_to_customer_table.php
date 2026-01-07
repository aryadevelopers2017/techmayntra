<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTravelAndStaffFieldsToCustomerTable extends Migration
{
    public function up()
    {
        Schema::table('customer', function (Blueprint $table) {
    // Assign Staff
    $table->unsignedInteger('assigned_staff')->nullable()->after('mobile');
    $table->string('country')->nullable()->after('assigned_staff');

    // Travel details
    $table->date('departure_date')->nullable()->after('gst_no');
    $table->date('return_date')->nullable()->after('departure_date');
    $table->unsignedInteger('travel_country')->nullable()->after('return_date');
    $table->unsignedInteger('travel_state')->nullable()->after('travel_country');
    $table->unsignedInteger('travel_city')->nullable()->after('travel_state');

});


    }

    public function down()
    {
        Schema::table('customer', function (Blueprint $table) {


            $table->dropColumn([
                'assigned_staff',
                'departure_date',
                'return_date',
                'travel_country',
                'travel_state',
                'travel_city'
            ]);
        });
    }
}
