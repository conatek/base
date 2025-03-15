<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('absences', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('collaborator_id');
            $table->boolean('is_extension')->default(0);
            $table->unsignedBigInteger('parent_absence_id')->nullable();
            $table->unsignedBigInteger('absence_type_id');
            $table->string('absence_subtype')->nullable();
            $table->string('disease_classification_code')->nullable();
            $table->string('description');
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('hours', 6, 2);
            $table->decimal('days', 6, 2);
            $table->string('support_file_public_id')->nullable();
            $table->string('support_file_url')->nullable();
            $table->text('observations')->nullable();

            $table->foreign('collaborator_id')->references('id')->on('collaborators');
            $table->foreign('absence_type_id')->references('id')->on('absence_types');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('absences');
    }
};
