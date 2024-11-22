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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('doctor_id')->constrained()->onDelete('cascade');
            $table->foreignId('nurse_id')->constrained()->onDelete('cascade');
            $table->foreignId('patient_record_id')->constrained()->onDelete('cascade');
            $table->foreignId('department_id')->constrained()->onDelete('cascade');

            // Order details
            $table->string('title');
            $table->enum('type', ['lab_test', 'procedure', 'imaging', 'medication', 'other'])->default('other'); // Type of order (e.g., lab test, imaging)
            $table->text('description')->nullable(); // Detailed description of the order (e.g., "ECG to monitor heart activity")
            $table->string('status')->default('pending'); // Status of the order (e.g., pending, completed)
            $table->date('order_date'); // Date the order was made
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
