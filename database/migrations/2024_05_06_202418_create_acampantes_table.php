<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAcampantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acampantes', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_entrada');
            $table->string('cargo');
            $table->string('nombre_completo');
            $table->string('email');
            $table->string('tipo_sangre');
            $table->string('tipo_documento_identificacion');
            $table->bigInteger('numero_identificacion');
            $table->date('fecha_nacimiento');
            $table->date('fecha_ingreso_club');
            $table->bigInteger('telefono');
            $table->string('direccion');
            $table->integer('Edad');
            $table->string('eps_afiliada');
            $table->string('alergico')->nullable();
            $table->string('medicamento_alergias')->nullable();
            $table->string('enfermedades_cronicas')->nullable();
            $table->string('medicamento_enfermedades_cronicas')->nullable();
            $table->string('en_caso_de_accidente_avisar_a');
            $table->string('relacion_persona_de_contacto');
            $table->string('telefono_persona_contacto');
            $table->foreignId('club_id')
            ->constrained('clubes')
            ->onDelete('cascade'); 
            //$table->foreignId('club_id');
            //$table->foreign('club_id')->references('id')->on('clubes');
            //$table->decimal('total', 10, 2)->nullable();












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
        Schema::dropIfExists('acampantes');
    }
}
