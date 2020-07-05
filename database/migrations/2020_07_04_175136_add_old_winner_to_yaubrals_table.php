<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOldWinnerToYaubralsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('yaubrals', function (Blueprint $table) {
            $table->tinyInteger('old_winner')->default(0);
            $table->tinyInteger('add_winner')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('yaubrals', function (Blueprint $table) {
            $table->dropColumn('old_winner');
            $table->dropColumn('add_winner');
        });
    }
}
