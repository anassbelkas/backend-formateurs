<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->text('tokenV')->nullable();
            $table->boolean('type')->default(0);
            $table->string('firstName')->nullable();
            $table->string('lastName')->nullable();
            $table->string('job')->nullable();
            $table->integer('age')->nullable();
            $table->text('adresse')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->bigInteger('codePostal')->nullable();
            $table->longText('aboutMe')->nullable();
            $table->text('picture')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
