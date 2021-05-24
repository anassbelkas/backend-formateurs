<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->text('title');
            $table->longText('description');
            $table->integer('nombreDeJours');
            $table->decimal('tarifsParJours');
            $table->integer('nombreDeParticipant');
            $table->text('modalites');
            $table->text('publicConcerne');
            $table->text('lieuFormation');
            $table->integer('dureeFormation');
            $table->date('dateDebut');
            $table->date('dateFin');
            $table->time('horaireDebut');
            $table->time('horaireFin');

            $table->foreign('user_id')->references('id')->on('users');

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
        Schema::dropIfExists('formations');
    }
}
