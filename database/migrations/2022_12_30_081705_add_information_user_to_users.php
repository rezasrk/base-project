<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInformationUserToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('code')->after('id')->nullable();
            $table->string('family')->after('name')->nullable();
            $table->string('child_number')->after('password')->nullable();
            $table->string('day_should_work_per_month')->after('password')->nullable();
            $table->integer('job_title_id')->after('password')->nullable();
            $table->integer('type_contract_id')->after('password')->nullable();
            $table->dropUnique('unique_users_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('code');
            $table->dropColumn('family');
            $table->dropColumn('child_number');
            $table->dropColumn('day_should_work_per_month');
            $table->dropColumn('job_title_id');
            $table->dropColumn('type_contract_id');
        });
    }
}
