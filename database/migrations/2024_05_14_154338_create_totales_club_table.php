<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTotalesClubTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('totales_club', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('club_id');
            $table->foreign('club_id')->references('id')->on('clubes')->onDelete('cascade');
            $table->integer('total_acampantes');
            $table->decimal('total_club', 10, 2);
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
        Schema::dropIfExists('totales_club');


    }
}
