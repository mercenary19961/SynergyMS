<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('status', ['Open', 'In Progress', 'Closed', 'Confirmed'])->default('Open');
            $table->enum('priority', ['Low', 'Medium', 'High'])->default('Medium');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Ticket issued by a user
            $table->foreignId('employee_id')->nullable()->constrained('employee_details')->onDelete('cascade');
            $table->foreignId('project_manager_id')->nullable()->constrained('project_managers')->onDelete('cascade');
            $table->foreignId('department_id')->nullable()->constrained('departments')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
}
