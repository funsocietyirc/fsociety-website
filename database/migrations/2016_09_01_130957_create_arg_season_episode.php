<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArgSeasonEpisode extends Migration
{
    protected $table = 'arg_season_episode';

    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('arg_id')->unsigned();
            $table->integer('episode_id')->unsigned();
            $table->unique([
               'arg_id', 'episode_id'
            ]);
            $table->timestamps();
        });

        Schema::table($this->table, function (Blueprint $table) {
            $table->foreign('episode_id')
                ->references('id')->on('episodes')->onDelete('cascade');
            $table->foreign('arg_id')
                ->references('id')->on('arg_tracking')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('arg_season_episode');
    }
}
