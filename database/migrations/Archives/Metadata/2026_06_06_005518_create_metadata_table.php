<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('metadata', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('archive_prossesed_id');
            $table->uuid('uuid')->unique();  //Uuid
            $table->String('rfc_emisor');  //RfcEmisor
            $table->String('nombre_emisor');  //NombreEmisor
            $table->String('rfc_receptor');  //RfcReceptor
            $table->String('nombre_receptor');  //NombreReceptor
            $table->String('pac_certifico');  //PacCertifico
            $table->dateTime('fecha_emision');  //FechaEmision
            $table->dateTime('fecha_certificacion_sat');  //FechaCertificacionSat
            $table->String('monto');  //Monto
            $table->String('iva');  //IVA
            $table->String('sub_total');  //SubTotal
            $table->String('efecto_comprobante');  //EfectoComprobante
            $table->boolean('estatus');  //Estatus
            $table->String('fecha_cancelacion')->nullable();  //FechaCancelacion 
            $table->String('state');  //estatus
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('metadata');
    }
};
