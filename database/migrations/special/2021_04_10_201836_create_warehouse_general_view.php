<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateWarehouseGeneralView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      DB::unprepared("drop view if exists warehouse_general;");
      DB::unprepared("
      create view warehouse_general
      as
      select
      ifnull((case when stde.type = 'MRS' then stde.amount end),0) as mrs,
      ifnull((case when stde.type = 'MIV' then -1 * stde.amount end),0) as miv,
      ifnull((case when stde.type = 'MRv' then stde.amount end),0) as mrv,
      ifnull((case when stde.type = 'MRS' then stde.price end),0) as price,
      ifnull((case when stde.type = 'MRS' then stde.price/stde.amount end),0) as a_product,
      stde.unit_price as currency,request_detail_no,stde.category_id,
      stde.date as warehouse_date, extra_value , requests.type , unit_requester_id,completeCategoryTitle(categories.id) as catTitle
      from store_details as  stde
      left join request_details
      on request_details.id = stde.request_detail_id
      left join requests
      on requests.id = request_details.request_id
      left join categories
      on categories.id = stde.category_id;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("drop view if exists warehouse_general;");
    }
}
