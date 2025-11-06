<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('collaborator_social_securities', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('collaborator_id')->unsigned();
            $table->bigInteger('eps_id')->unsigned();
            $table->string('eps_certificate_public_id')->nullable();
            $table->string('eps_certificate_url')->nullable();
            $table->bigInteger('afp_pension_id')->unsigned();
            $table->string('afp_pension_certificate_public_id')->nullable();
            $table->string('afp_pension_certificate_url')->nullable();
            $table->bigInteger('afp_saving_id')->unsigned();
            $table->string('afp_saving_certificate_public_id')->nullable();
            $table->string('afp_saving_certificate_url')->nullable();
            $table->bigInteger('arl_id')->unsigned();
            $table->bigInteger('ccf_id')->unsigned();
            $table->text('observations')->nullable();
            $table->timestamps();

            // Llaves foráneas
            $table->foreign('collaborator_id')->references('id')->on('collaborators');
            $table->foreign('eps_id')->references('id')->on('eps_types');
            $table->foreign('afp_pension_id')->references('id')->on('afp_types');
            $table->foreign('afp_saving_id')->references('id')->on('afp_types');
            $table->foreign('arl_id')->references('id')->on('arl_types');
            $table->foreign('ccf_id')->references('id')->on('ccf_types');

            // Un colaborador tiene una sola configuración de seguridad social
            $table->unique('collaborator_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('collaborator_social_securities');
    }
};
