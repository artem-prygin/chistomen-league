<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateYarazdelilsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yarazdelils', function (Blueprint $table) {
            $table->id();
            $table->integer('week_id')->default(1);
            $table->string('author');
            $table->string('author_ip');
            $table->string('link');
            $table->smallInteger('checked')->default(0);
            $table->tinyInteger('finished')->default(0);
            $table->tinyInteger('win')->default(0);
            $table->string('video')->nullable();
            $table->tinyInteger('old_winner')->default(0);
            $table->tinyInteger('add_winner')->default(0);
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
        Schema::dropIfExists('yarazdelils');
    }
}
