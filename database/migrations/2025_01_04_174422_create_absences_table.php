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
            $table->unsignedBigInteger('contingency_type_id');
            $table->unsignedBigInteger('classification_id');
            $table->string('description');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('days_quantity');
            $table->integer('hours_quantity');
            $table->unsignedBigInteger('absence_segment_id');

            $table->foreign('collaborator_id')->references('id')->on('collaborators');
            $table->foreign('contingency_type_id')->references('id')->on('contingencies');
            $table->foreign('classification_id')->references('id')->on('classifications');
            $table->foreign('absence_segment_id')->references('id')->on('absence_segments');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('absences');
    }
};
