<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArgTracking extends Migration
{
    protected $table = 'arg_tracking';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('season_mentioned_id')->unsigned();
            $table->integer('episode_mentioned_id')->unsigned();
            $table->string('url')->unique();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        Schema::table($this->table, function (Blueprint $table) {
            $table->foreign('season_mentioned_id')
                ->references('id')->on('seasons')->onDelete('cascade');
            $table->foreign('episode_mentioned_id')
                ->references('id')->on('episodes')->onDelete('cascade');
            $table->foreign('user_id')
                ->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->table);
    }
}
