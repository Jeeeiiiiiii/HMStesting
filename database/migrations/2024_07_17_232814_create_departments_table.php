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
        Schema::create('departments', function (Blueprint $table) {
            $table->id(); // Primary key: unique identifier for each department
            $table->string('department_name'); // Department name, e.g., "Emergency Room"
            $table->string('department_code')->unique(); // Unique department code, e.g., "ER"
            $table->string('email')->unique(); // Official department or department head email
            $table->string('password'); // Encrypted password for department account
            $table->string('phone_number')->nullable(); // Contact phone number (optional)
            $table->string('address')->nullable(); // Physical address of the department (optional)
            $table->foreignId('head_id')->nullable()->constrained('doctors'); // Foreign key reference to doctors table
            $table->timestamps(); // Created_at and updated_at timestamps for the record
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
