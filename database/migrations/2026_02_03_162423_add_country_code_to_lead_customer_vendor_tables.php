<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCountryCodeToLeadCustomerVendorTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Lead Master
        Schema::table('lead_master', function (Blueprint $table) {
            if (!Schema::hasColumn('lead_master', 'country_code')) {
                $table->string('country_code', 5)->nullable()->after('country');
            }
        });

        // Customer
        Schema::table('customer', function (Blueprint $table) {
            if (!Schema::hasColumn('customer', 'country_code')) {
                $table->string('country_code', 5)->nullable()->after('country');
            }
        });

        // Vendor Master
        Schema::table('vendor_master', function (Blueprint $table) {
            if (!Schema::hasColumn('vendor_master', 'country_code')) {
                $table->string('country_code', 5)->nullable()->after('country');
            }
        });
    }

    public function down()
    {
        Schema::table('lead_master', function (Blueprint $table) {
            $table->dropColumn('country_code');
        });

        Schema::table('customer', function (Blueprint $table) {
            $table->dropColumn('country_code');
        });

        Schema::table('vendor_master', function (Blueprint $table) {
            $table->dropColumn('country_code');
        });
    }
}
