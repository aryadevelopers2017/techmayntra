<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyModuleMaster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_module_master', function (Blueprint $table) {
            $table->id();
            $table->longText('milestone')->nullable();
			$table->longText('milestone_label')->nullable();
            $table->longText('terms_conditions')->nullable();
            $table->longText('payment_terms_conditions')->nullable();
            $table->longText('bank_details')->nullable();
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
        Schema::dropIfExists('company_module_master');
    }
}
