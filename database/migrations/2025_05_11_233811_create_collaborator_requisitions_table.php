<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('collaborator_requisitions', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('requisition_type_id');
            $table->unsignedBigInteger('area_id');
            $table->unsignedBigInteger('position_id');
            $table->unsignedBigInteger('vacancy_reason_id');
            $table->unsignedBigInteger('requested_by_id');
            $table->unsignedBigInteger('replaces_id')->nullable();
            $table->unsignedBigInteger('selection_source_id')->nullable();
            $table->unsignedBigInteger('vacancy_status_id');

            $table->date('request_date');
            $table->date('closing_date')->nullable();
            $table->integer('vacancy_duration_days')->nullable();
            $table->unsignedBigInteger('hired_person_id')->nullable();

            $table->timestamps();

            // Llaves foráneas
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('restrict');
            $table->foreign('requisition_type_id')->references('id')->on('collaborator_requisition_types')->onDelete('restrict');
            $table->foreign('area_id')->references('id')->on('areas')->onDelete('restrict');
            $table->foreign('position_id')->references('id')->on('positions')->onDelete('restrict');
            $table->foreign('vacancy_reason_id')->references('id')->on('vacancy_reasons')->onDelete('restrict');
            $table->foreign('vacancy_status_id')->references('id')->on('vacancy_statuses')->onDelete('restrict');
            $table->foreign('requested_by_id')->references('id')->on('collaborators')->onDelete('restrict');
            $table->foreign('replaces_id')->references('id')->on('collaborators')->onDelete('set null');
            $table->foreign('selection_source_id')->references('id')->on('selection_sources')->onDelete('set null');
            $table->foreign('hired_person_id')->references('id')->on('collaborators')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('collaborator_requisitions');
    }
};
