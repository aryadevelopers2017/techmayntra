<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraFieldsToItemMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('item_master', function (Blueprint $table) {
            $table->unsignedBigInteger('vendor_id')->nullable()->after('id');
            $table->decimal('admin_cost')->nullable()->after('vendor_id');

            $table->unsignedBigInteger('category_id')->nullable()->after('admin_cost');
            $table->unsignedBigInteger('subcategory_id')->nullable()->after('category_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::table('item_master', function (Blueprint $table) {

            $table->dropColumn([
                'vendor_id',
                'admin_cost',
                'category_id',
                'subcategory_id'
            ]);

        });
    }
}
