<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aper_evaluation', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('aper_id');
            $table->unsignedBigInteger('appraiser_id');
            $table->integer('foresight');
            $table->integer('penetration');
            $table->integer('judgement');
            $table->integer('written_expression');
            $table->integer('oral_expression');
            $table->integer('numeracy')->nullable();
            $table->integer('staff_relationship');
            $table->integer('student_relationship');
            $table->integer('accepts_responsibility');
            $table->integer('pressure_reliabilty');
            $table->integer('drive');
            $table->integer('knowledge_application')->nullable();
            $table->integer('staff_management')->nullable();
            $table->integer('work_output');
            $table->integer('work_quality');
            $table->integer('punctuality');
            $table->integer('time_management');
            $table->integer('comportment');
            $table->integer('ict_literacy');
            $table->integer('query_commendations');

            $table->unsignedFloat('grade');
            $table->unsignedBigInteger('status_id');
            $table->longText('note');

            $table->foreign('aper_id')->references('id')->on('aper')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('appraiser_id')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('status_id')->references('id')->on('aper_status')
                ->onUpdate('cascade')
                ->onDelete('restrict');

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
        Schema::dropIfExists('aper_evaluation');
    }
};
