<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('collaborator_requisitions', function (Blueprint $table) {
            // Renombrar campos existentes para consistencia con cancelled_*
            $table->renameColumn('approval_date', 'approved_at');
            $table->renameColumn('approval_comments', 'approval_reason');

            // Agregar nuevos campos de cancelación
            $table->unsignedBigInteger('cancelled_by_id')->nullable()->after('approval_reason');
            $table->dateTime('cancelled_at')->nullable()->after('cancelled_by_id');
            $table->text('cancellation_reason')->nullable()->after('cancelled_at');

            $table->foreign('cancelled_by_id')
                  ->references('id')
                  ->on('collaborators')
                  ->onUpdate('no action')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('collaborator_requisitions', function (Blueprint $table) {
            $table->dropForeign(['cancelled_by_id']);
            $table->dropColumn(['cancelled_by_id', 'cancelled_at', 'cancellation_reason']);

            // Revertir los cambios de nombre
            $table->renameColumn('approved_at', 'approval_date');
            $table->renameColumn('approval_reason', 'approval_comments');
        });
    }
};
