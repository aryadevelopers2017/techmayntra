<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class MakeWorkingDaysNullableInQuotationTable extends Migration
{
    /**`
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          DB::statement('ALTER TABLE quotation MODIFY working_days INT NULL');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
               DB::statement('ALTER TABLE quotation MODIFY working_days INT NOT NULL');

    }
}
