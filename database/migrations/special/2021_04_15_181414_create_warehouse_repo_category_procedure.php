<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateWarehouseRepoCategoryProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared(' drop procedure if exists  warehouseRepoCategory;');
        DB::unprepared("
            create procedure warehouseRepoCategory(
                in conditionCategory int,
                in projectId int,
                in s_date varchar(15),
                in e_date varchar(15)
            )
            begin

                select
                    completeCategoryTitle(categories.id) as completeTitle,
                    details.*,unit.value as unitVal,discipline.value as disciplineVal,
                    categories.code as categoryCode,(mrs + mrv + miv) as existsCategory
                from categories
                join (
                select
                    category_id,
                    sum(case when type = 'MRS' then amount else 0 end) as mrs,
                    sum(case when type = 'MRV' then amount else 0 end) as mrv,
                    sum(case when type = 'MIV' then -1 * amount else 0 end) as miv
                from store_details
                where store_details.condition_category = conditionCategory and store_details.project_id = projectId
                and store_details.date between s_date and e_date
                group by store_details.category_id
                    ) as details
                on categories.id = details.category_id
                left join baseinfos as unit
                on unit.id = categories.unit_id
                left join baseinfos as discipline
                on categories.discipline_id = discipline.id;
            end
       ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared(' drop procedure if exists  warehouseRepoCategory;');
    }
}
