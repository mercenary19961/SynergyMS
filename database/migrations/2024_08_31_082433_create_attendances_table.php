<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employee_details')->onDelete('cascade');
            $table->date('attendance_date');
            $table->time('clock_in')->nullable();
            $table->time('clock_out')->nullable();
            $table->smallInteger('total_hours')->nullable();
            $table->smallInteger('leave_hours')->nullable();
            $table->enum('status', ['Present', 'Absent', 'Leave', 'Hourly Leave', 'Annual Leave', 'Sick Leave', 'Day Off'])->default('Present'); // Updated enum values
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendance');
    }
};
