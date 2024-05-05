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
        Schema::table('aper_evaluation_questions', function (Blueprint $table) {
            $table->string('field')->after('low');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('aper_evaluation_questions', function (Blueprint $table) {
            $table->dropColumn('field');
        });
    }
};
