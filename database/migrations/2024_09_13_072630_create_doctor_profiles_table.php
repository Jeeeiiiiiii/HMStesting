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
        Schema::create('doctor_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->integer('age');
            $table->date('birthday');
            $table->string('specialization');
            $table->string('birthplace');
            $table->string('civil_status');
            $table->string('religion');
            $table->string('nationality');
            $table->string('gender');
            $table->string('telephone_no');
            $table->string('emergency_email')->nullable();
            $table->string('emergency_telephone_no')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor_profiles');
    }
};
