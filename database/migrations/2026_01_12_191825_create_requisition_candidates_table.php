<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('requisition_candidates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('requisition_id')->constrained('collaborator_requisitions')->cascadeOnDelete();
            $table->foreignId('candidate_id')->constrained('candidates')->cascadeOnDelete();
            
            // Origen específico para esta postulación (ej: esta vez vino por LinkedIn, aunque antes vino por referido)
            $table->foreignId('source_id')->nullable()->constrained('selection_sources')->nullOnDelete();

            // Estado del candidato en ESTE proceso
            // Estados sugeridos: 'applied', 'pre_screened', 'interview', 'technical_test', 'psychometric', 'medical', 'hiring', 'hired', 'rejected'
            $table->string('current_phase')->default('applied'); 
            
            // Detalles específicos solicitados
            $table->string('video_presentation_url')->nullable();
            
            // Resultados de fases (JSON es útil para flexibilidad, o columnas específicas)
            $table->enum('interview_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('interview_notes')->nullable();
            
            $table->enum('technical_test_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->decimal('technical_score', 5, 2)->nullable(); // Ej: 85.50
            
            $table->decimal('psychometric_score', 5, 2)->nullable(); // Porcentaje aprobación
            
            $table->enum('references_status', ['pending', 'recommended', 'not_recommended'])->default('pending');
            $table->text('references_notes')->nullable();

            // Fases de contratación
            $table->enum('medical_exam_status', ['pending', 'approved', 'rejected'])->default('pending');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('requisition_candidates');
    }
};
