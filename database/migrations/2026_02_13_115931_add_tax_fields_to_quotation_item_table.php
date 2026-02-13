<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTaxFieldsToQuotationItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quotation_item', function (Blueprint $table) {
               $table->text('taxtype')->nullable()->after('original_price');
            $table->text('taxvalue')->nullable()->after('taxtype');
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
            $table->dropColumn(['taxtype', 'taxvalue']);

        });
    }
}
