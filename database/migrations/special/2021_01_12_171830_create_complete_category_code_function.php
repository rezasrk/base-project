<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateCompleteCategoryCodeFunction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('drop function if exists completeCategoryCode;');
        DB::unprepared("
            create function completeCategoryCode(categoryId int)
            returns varchar(100) charset utf8 deterministic
            begin
            declare completeCode varchar(100) charset utf8;
            declare disposableCode varchar(100)  charset utf8;
            declare parentId int;
            declare counter int;
            declare maxRecursive int;

            select value into maxRecursive from settings where settings.key = 'limit_complete_tile_recursive';


            set completeCode = '';
            set counter = 0;

             select code,category_parent_id into disposableCode,parentId from categories where id = categoryId;
             set completeCode = concat(disposableCode,completeCode);

             complete_title_loop:while parentId <> 0
             do
                 set counter = counter + 1;
                 if counter > maxRecursive
                 then
                    leave complete_title_loop;
                 end if;
                select code,category_parent_id into disposableCode,parentId from categories where id = parentId;
                 set completeCode = concat_ws('',disposableCode,completeCode);

             end while complete_title_loop;

            return completeCode;
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
        DB::unprepared('drop function if exists completeCategoryCode;');
    }
}
