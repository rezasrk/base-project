<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use \Illuminate\Support\Facades\DB;

class CreateUserProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_projects', function (Blueprint $table) {
           $table->unsignedBigInteger('user_id');
           $table->unsignedBigInteger('project_id');

           $table->foreign('user_id')->references('id')->on('users');
           $table->foreign('project_id')->references('id')->on('projects');
        });

        DB::table('projects')->insert(['id'=>1,'project_title'=>'پروژه']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_projects');
    }
}
