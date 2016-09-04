<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIgnoreHashFieldToArgTracking extends Migration
{
    protected $table = 'arg_tracking';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->table, function(Blueprint $table) {
           $table->boolean('ignoreHash')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table($this->table, function (Blueprint $table) {
           $table->dropColumn('ignoreHash');
        });
    }
}
