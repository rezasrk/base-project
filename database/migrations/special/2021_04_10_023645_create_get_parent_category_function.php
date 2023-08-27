<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateGetParentCategoryFunction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       DB::unprepared(" drop function if exists getParentCategory;");
       DB::unprepared("
       create function getParentCategory(parentId int,categoryId int)
       returns int deterministic
       begin

           declare catId int ;
           declare counter int;

           select category_parent_id into catId  from categories where id = categoryId ;
           set counter = 0;

           parent_category_loop:while catId <> 0
           do
               select category_parent_id into catId from  categories where id = catId ;
               set counter = counter + 1;
               if counter = 20
               then
                   leave parent_category_loop;
               end if ;

               if catId = parentId
               then
                   return 1;
               end if ;
           end while;

           return 0;
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
        DB::unprepared(" drop function if exists getParentCategory;");
    }
}
