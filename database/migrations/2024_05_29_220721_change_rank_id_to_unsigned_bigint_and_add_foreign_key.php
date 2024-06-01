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
        Schema::table('first_appointment', function (Blueprint $table) {
            $table->unsignedBigInteger('rank_id')->change();

            // Add the foreign key constraint
            $table->foreign('rank_id')->references('id')->on('ranks')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('first_appointment', function (Blueprint $table) {
            $table->dropForeign(['rank_id']);

            // Optionally, change the column back to string
            $table->string('rank_id')->change();
        });
    }
};
