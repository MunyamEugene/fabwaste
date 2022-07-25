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
        Schema::create('collect_manufact', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('coll_id')->unsigned()->index();
            $table->bigInteger('manu_id')->unsigned()->index();
            $table->foreign('coll_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('manu_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('collect_manufact');
    }
};
