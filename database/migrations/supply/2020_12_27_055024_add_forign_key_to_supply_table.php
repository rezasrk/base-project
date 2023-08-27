<?php

use App\Models\Supply\Category;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddForignKeyToSupplyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            // $table->unsignedBigInteger('discipline_id')->default(46)->change();
            // $table->foreign('discipline_id')->references('id')->on('baseinfos');

            // $table->unsignedBigInteger('unit_id')->default(46)->change();
            // $table->foreign('unit_id')->references('id')->on('baseinfos');

            // $table->unsignedBigInteger('category_parent_id')->default(0)->change();

            // $table->unique(['code','category_parent_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            // $table->dropUnique(['code','category_parent_id']);
            // $table->dropForeign('categories_discipline_id_foreign');
            // $table->dropForeign('categories_unit_id_foreign');

        });
    }
}
