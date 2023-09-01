<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropColumn('title');
            $table->dropColumn('family');
            $table->dropColumn('is_parent');
            $table->integer('parent_id')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permissions', function (Blueprint $table) {
            $table->string('title')->nullable();
            $table->string('family')->nullable();
            $table->boolean('is_parent')->default(0);
            $table->dropColumn('parent_id');
        });
    }
};
