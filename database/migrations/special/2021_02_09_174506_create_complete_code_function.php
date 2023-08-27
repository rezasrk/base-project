<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCompleteCodeFunction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	DB::unprepared('drop function if exists completeCode;');
        DB::unprepared("
        create function completeCode(categoryId int)
        returns varchar(15) charset utf8 deterministic
        begin
            declare completeCategoryCode varchar(14) charset utf8;
            declare counter int;
            declare codeLength int;

            set counter = 0;

            select categories.code into completeCategoryCode from categories where id = categoryId;

            if char_length(completeCategoryCode) < 12
            then
            set codeLength =  12 - char_length(completeCategoryCode);
            while counter < codeLength
            do
                set completeCategoryCode = concat(completeCategoryCode,'0');
                set counter = counter + 1;
            end while;
            end if ;

            return completeCategoryCode;
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
        DB::unprepared('drop function if exists completeCode;');
    }
}
