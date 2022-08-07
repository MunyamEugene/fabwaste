<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
            $table->string('firstName')->nullable(true);
            $table->string('lastName')->nullable(true);
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('location')->nullable(true);
            $table->string('province')->nullable(true);
            $table->string('district')->nullable(true);
            $table->string('city')->nullable(true);
            $table->string('streetNumber')->nullable(true);
            $table->string('pobox')->nullable(true);
            $table->string('manufactureName')->nullable(true);
            $table->boolean('iscollector')->default(false);
            $table->boolean('ismanufacture')->default(false);
            $table->boolean('isadmin')->default(false);
            $table->boolean('isapproved')->default(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
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
};
