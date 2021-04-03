<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post', function (Blueprint $table) {
            $table->increments('id');
            $table->string('titulo');
            $table->string('autor');
            $table->string('post');
            //$table->string('imagem');
            // $table->string('tipo'); foreink key

            $table->integer('tipo_post_id')->unsigned();
            $table->foreign('tipo_post_id')->references('id')->on('tipo_post');

            $table->integer('id_foto')->unsigned()->nullable();
            $table->foreign('id_foto')->references('id')->on('fotos');

            $table->integer('id_user')->unsigned();
            $table->foreign('id_user')->references('id')->on('users'); // autor

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post');
    }
}
