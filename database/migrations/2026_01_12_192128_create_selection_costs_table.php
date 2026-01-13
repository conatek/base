<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('selection_cost_types', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Ej: Examen Médico, Polígrafo, Hora Entrevista
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('requisition_costs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('requisition_id')->constrained('collaborator_requisitions')->cascadeOnDelete();
            $table->foreignId('cost_type_id')->constrained('selection_cost_types');
            
            $table->string('provider_name')->nullable(); // Proveedor externo si aplica
            $table->decimal('amount', 12, 2); // Costo monetario
            $table->text('description')->nullable(); // Detalle adicional
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('requisition_costs');
        Schema::dropIfExists('selection_cost_types');
    }
};
