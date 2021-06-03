<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQualitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qualities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('formation_id')->unique()->constrained()->onDelete('cascade');
            $table->integer('preparation');
            $table->integer('organisation');
            $table->integer('deroulement');
            $table->integer('contenu');
            $table->integer('efficacite');
            $table->longText('avis');
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
        Schema::dropIfExists('qualities');
    }
}
