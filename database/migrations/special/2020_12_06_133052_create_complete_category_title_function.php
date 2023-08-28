<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateCompleteCategoryTitleFunction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('drop function if exists completeCategoryTitle;');
        DB::unprepared("
        create function completeCategoryTitle(categoryId int)
        returns text charset utf8 deterministic
        begin
            declare fullTitle text charset utf8;
            declare disposableTitle varchar(300) charset utf8;
            declare parentId int;
            declare counter int;
            declare maxRecursive int;

            select value into maxRecursive from settings where settings.key = 'limit_complete_tile_recursive';


            set fullTitle = '';
			set counter = 0;

             select category_title,category_parent_id into disposableTitle,parentId from categories where id = categoryId;
             set fullTitle = concat(disposableTitle,fullTitle);

             complete_title_loop:while parentId <> 0
             do
             	 set counter = counter + 1;
                 if counter > maxRecursive
                 then
                 	leave complete_title_loop;
                 end if;
                select category_title,category_parent_id into disposableTitle,parentId from categories where id = parentId;
                 set fullTitle = concat_ws(' - ',disposableTitle,fullTitle);

             end while complete_title_loop;

       		return fullTitle;
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
        DB::unprepared('drop function if exists completeCategoryTitle;');
    }
}
