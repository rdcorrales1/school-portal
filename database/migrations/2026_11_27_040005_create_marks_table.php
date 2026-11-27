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
        Schema::create('marks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('quarter');
            // Range 0 to 100 is checked in the Form Request, not here.
            $table->unsignedTinyInteger('mark');
            $table->timestamps();

            // Only one mark per student, subject and quarter.
            $table->unique(['student_id', 'subject_id', 'quarter']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marks');
    }
};
