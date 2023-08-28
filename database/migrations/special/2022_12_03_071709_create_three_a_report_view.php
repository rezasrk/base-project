<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateThreeAReportView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('drop view if exists three_a_report');
        DB::unprepared("
        create view three_a_report as  
        select
            category_id ,
            sum(
            case 
            when store_details.`type` = 'mrs' then store_details.amount  
            end
            ) as mrs ,
            ifnull(sum(
            case 
            when store_details.`type` = 'miv' then store_details.amount  
            end
            ),0) as miv ,
            ifnull(sum(
            case 
            when store_details.`type` = 'mrv' then store_details.amount  
            end
            ),0) as mrv 
            from store_details 
        where store_details.category_id  in (select category_id  from request_details 
        where request_id in (
        select id from requests 
        where requests.extra_value in ('three','three-a')
        )
        group by category_id 
        ) and  project_id = 2 group by category_id 
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('drop view if exists three_a_report');
    }
}
