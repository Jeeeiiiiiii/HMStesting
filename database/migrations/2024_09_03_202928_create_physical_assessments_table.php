<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('physical_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->string('general_appearance');
            $table->integer('pain_assessment')->nullable(); // pain scale, e.g., 0-10
            $table->text('pain_description')->nullable(); // detailed pain description
            $table->text('changes_in_condition')->nullable(); // any changes since last assessment
            $table->timestamp('assessment_date');
            $table->foreignId('nurse_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('physical_assessments');
    }
};
