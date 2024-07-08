<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('aper_acceptance', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('aper_id');
            $table->unsignedBigInteger('staff_id');
            $table->unsignedBigInteger('status_id');
            $table->longText('note')->nullable();

            $table->foreign('aper_id')->references('id')->on('aper')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('staff_id')->references('id')->on('users')
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
     */
    public function down(): void
    {
        Schema::dropIfExists('aper_acceptance');
    }
};
