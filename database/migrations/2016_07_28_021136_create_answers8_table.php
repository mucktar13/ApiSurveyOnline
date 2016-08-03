<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnswers8Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answers8', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_correspondent')->unsigned();
            $table->string('institusi', 250);
            $table->double('jumlah_dana', 15, 8);
            $table->timestamps();
            $table->index(['id_correspondent']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('answers8');
    }
}