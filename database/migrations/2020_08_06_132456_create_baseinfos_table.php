<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBaseinfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('baseinfos', function (Blueprint $table) {
            $table->id();
            $table->string('value')->nullable();
            $table->string('type')->nullable();
            $table->integer('parent_id')->default(0);
            $table->boolean('user_can_add')->default(0);
            $table->string('extra_value')->nullable();
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
        Schema::dropIfExists('baseinfos');
    }
}
