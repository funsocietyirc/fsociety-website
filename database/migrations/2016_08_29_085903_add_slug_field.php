<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSlugField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('arg_tracking', function (Blueprint $table) {
            $table->string('slug')->nullable();
        });
        Schema::table('episodes', function (Blueprint $table) {
            $table->string('slug')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('arg_tracking', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
        Schema::table('episodes', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
}
