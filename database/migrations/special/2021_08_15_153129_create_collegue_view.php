<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateCollegueView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('drop view if exists collegue');
        DB::unprepared(
            '
        create view collegue
        as 
        select completeCategoryTitle(categories.id) as title,coll.* from categories
        join (
            select 
            replace(JSON_EXTRACT(extra,"$.extra_c"),\'"\',\'\') as colleague_code,store_details.category_id,
            sum(case when type = "MRS" then store_details.amount end ) as mrs 
            from store_details
            where extra is not null and replace(JSON_EXTRACT(extra,"$.extra_c"),\'"\',\'\') <> "" 
            group by  replace(JSON_EXTRACT(extra,"$.extra_c"),\'"\',\'\'),store_details.category_id 
        ) as coll 
        on coll.category_id = categories.id 
        order by categories.id 
        '
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('drop view if exists collegue');
    }
}
