<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateWarehouseSumView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('drop view if exists warehouse_sum');
        DB::unprepared('
        create view warehouse_sum
        as 
        select 
            sum(case when type = "MRV" then store_details.amount end ) as mrv,
            sum(case when type = "MIV" then store_details.amount end ) as miv,
            category_id as cat_id
        from store_details
        where type <> "MRS"
        group by category_id
       ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('drop view if exists warehouse_sum');
    }
}
