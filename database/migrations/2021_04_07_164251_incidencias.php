<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Incidencias extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incidencias', function (Blueprint $table) {
            $table->id();
            $table->string('icd_BU')->nullable();
            $table->string('icd_Area_linea');
            $table->string('icd_Proceso');
            $table->string('icd_Equipment_System');
            $table->string('icd_Component');
            $table->string('icd_Subsystem');
            $table->string('icd_ControlPanel');
            $table->string('icd_IssueType');
            $table->string('icd_ActionRequired');
            $table->string('icd_Priority');
            $table->string('icd_Responsible');
            $table->string('icd_Shift');
            $table->string('icd_ReportingDate');
            $table->string('icd_ClosingDate');
            $table->string('icd_ResponseTime');
            $table->string('icd_StartTime');
            $table->string('icd_EndTime');
            $table->string('icd_TotalTime');
            $table->string('icd_DiagramaProcManual');
            $table->string('icd_Respaldo');
            $table->string('icd_Refaccion');
            $table->string('icd_reportedBy');
            $table->string('icd_tiempoDiagnosticar');
            $table->text('icd_ProblemDescription');
            $table->text('icd_Comments');
            $table->integer('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
