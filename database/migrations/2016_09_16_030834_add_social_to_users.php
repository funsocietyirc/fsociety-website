<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSocialToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('email')->nullable()->change();
            $table->string('nick')->unique();
        });
        Fsociety\Models\User::all()->each(function(Fsociety\Models\User $user){
            if(Schema::hasColumn('users','name')) {
                $user->update(['nick' => $user->name]);
            }
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('name');
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
            $table->string('email')->change();
            $table->dropUnique('users_nick_unique');
            $table->dropColumn('nick');
            $table->string('name');
        });
    }
}
