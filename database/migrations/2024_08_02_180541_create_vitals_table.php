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
        Schema::create('vitals', 
 function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade'); 
            $table->string('body_temperature'); // Adjust precision as needed
            $table->string('blood_pressure');
            $table->string('respiratory_rate');
            $table->string('weight'); // Adjust precision as needed
            $table->string('height'); // Adjust precision as needed
            $table->string('pulse_rate');
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
        Schema::dropIfExists('vitals');
    }
};
