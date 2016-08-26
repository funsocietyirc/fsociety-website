<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeasonEpisode extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seasons', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('number')->unique();
            $table->string('tagline')->nullable();
            $table->timestamps();
        });

        Schema::create('episodes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('season_id')->unsigned();
            $table->string('name')->nullable();

            // TV API
            $table->integer('number');
            $table->string('airdate')->nullable();
            $table->string('airtime')->nullable();
            $table->string('airstamp')->nullable();
            $table->string('runtime')->nullable();
            $table->string('imageMedium')->nullable();
            $table->string('imageOriginal')->nullable();
            $table->string('summary',1000)->nullable();

            $table->timestamps();
        });

        Schema::table('episodes', function (Blueprint $table) {
            $table->foreign('season_id')
                ->references('id')->on('seasons')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('episodes', function(Blueprint $table) {
            $table->dropForeign('episodes_season_id_foreign');
        });
        Schema::dropIfExists('seasons');
        Schema::dropIfExists('episodes');
    }
}
