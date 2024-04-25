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
        Schema::create('aper_appraisal', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('aper_id');
            $table->unsignedBigInteger('appraiser_id');
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
        Schema::dropIfExists('aper_appraisal');
    }
};
