<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->string('subject', 100)->nullable();
            $table->string('applicant_name', 70)->nullable();
            $table->string('status');
            $table->float('total_price', 20, 2)->default(0);
            $table->dateTime('date')->nullable();
            $table->integer('assign_id')->default(0);
            $table->string('type', 15)->comment('supply or deliver');
            $table->integer('creator_id');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requests');
    }
}
