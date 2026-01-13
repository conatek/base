<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('collaborator_requisitions', function (Blueprint $table) {
            // Eliminar la relación 1 a 1 anterior
            $table->dropForeign(['hired_person_id']);
            $table->dropColumn('hired_person_id');

            // Nuevos campos
            $table->integer('vacancies_count')->default(1)->after('position_id'); // Cantidad solicitada (ej. 3 soldadores)
            $table->text('observations')->nullable()->after('vacancies_count');
            
            // Control de Aprobación
            $table->unsignedBigInteger('approved_by_id')->nullable()->after('requested_by_id');
            $table->text('approval_comments')->nullable()->after('approved_by_id'); // Observaciones del aprobador
            $table->dateTime('approval_date')->nullable()->after('approved_by_id');
            
            // Relación con usuario aprobador (asumiendo que es un collaborator o user)
            $table->foreign('approved_by_id')->references('id')->on('collaborators')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('collaborator_requisitions', function (Blueprint $table) {
            // Revertir los cambios realizados en el método up
            $table->unsignedBigInteger('hired_person_id')->nullable()->after('position_id');
            $table->foreign('hired_person_id')->references('id')->on('collaborators')->nullOnDelete();

            $table->dropColumn('vacancies_count');
            $table->dropForeign(['approved_by_id']);
            $table->dropColumn('approved_by_id');
            $table->dropColumn('approval_comments');
            $table->dropColumn('approval_date');
        });
    }
};
