<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            // Datos básicos
            $table->string('first_name');
            $table->string('first_surname');
            $table->string('second_surname')->nullable();
            $table->string('email')->nullable(); // Opcional según requerimiento, pero recomendado único si existe
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            
            // Documento CV base (puede actualizarse)
            $table->string('resume_path')->nullable(); 
            
            // Origen global (la primera vez que llegó a la empresa)
            $table->foreignId('origin_source_id')->nullable()->constrained('selection_sources')->nullOnDelete();
            
            $table->timestamps();
            $table->softDeletes(); // Importante para no perder historial
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('candidates');
    }
};
