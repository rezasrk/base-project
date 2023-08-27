<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateWarehouseView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	DB::unprepared("drop view if exists warehouse");
        DB::unprepared("
            create view warehouse as
            select
            completeCategoryTitle(categories.id) as complete_title,ifnull(mrs,0) as mrs,ifnull(miv,0) as miv,
            ifnull(mrv,0) as mrv,categories.id as id,unit.value as unit_val,project_id,
            discipline.value as discipline_val,unit.id as unit_id,discipline.id as discipline_id

            from categories
            join (select sum(amount) as mrs,category_id from store_details
            where store_details.type = 'MRS' and store_details.request_detail_id in (select id from request_details)
            group by category_id
            ) as storMrs
            on storMrs.category_id=categories.id
            left join  (
            select sum(amount) as miv,category_id from store_details
            where store_details.type = 'MIV'
            group by category_id
            ) as storMiv
            on storMiv.category_id=categories.id
            left join  (
            select sum(amount) as mrv,category_id from store_details
            where store_details.type = 'MRV'
            group by category_id
            ) as storMrv
            on storMrv.category_id=categories.id
            left join baseinfos as unit
            on unit.id = categories.unit_id
            left join baseinfos as discipline
            on discipline.id = categories.discipline_id
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("drop view if exists warehouse");
    }
}
