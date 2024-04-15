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
        Schema::create('staff_publications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->text('title');
            $table->text('authors');
            $table->year('year');
            $table->string('journal');
            $table->string('journal_volume');
            $table->string('doi')->nullable();
            $table->string('abstract')->nullable();
            $table->string('abstractFileName')->nullable();
            $table->string('evidence')->nullable();
            $table->string('evidenceFileName')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->longText('details')->nullable();

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('category_id')->references('id')->on('publication_categories')
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
        Schema::dropIfExists('staff_publications');
    }
};
