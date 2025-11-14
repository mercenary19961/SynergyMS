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
        // Add composite index for attendances (frequently filtered together)
        if (!$this->indexExists('attendances', 'idx_employee_attendance_date')) {
            Schema::table('attendances', function (Blueprint $table) {
                $table->index(['employee_id', 'attendance_date'], 'idx_employee_attendance_date');
            });
        }
        if (!$this->indexExists('attendances', 'idx_attendance_status')) {
            Schema::table('attendances', function (Blueprint $table) {
                $table->index('status', 'idx_attendance_status');
            });
        }

        // Add composite index for tickets (status and priority often filtered together)
        if (!$this->indexExists('tickets', 'idx_ticket_status_priority')) {
            Schema::table('tickets', function (Blueprint $table) {
                $table->index(['status', 'priority'], 'idx_ticket_status_priority');
            });
        }
        if (!$this->indexExists('tickets', 'idx_ticket_department')) {
            Schema::table('tickets', function (Blueprint $table) {
                $table->index('department_id', 'idx_ticket_department');
            });
        }

        // Add composite index for projects (status and department)
        if (!$this->indexExists('projects', 'idx_project_status_department')) {
            Schema::table('projects', function (Blueprint $table) {
                $table->index(['status', 'department_id'], 'idx_project_status_department');
            });
        }

        // Add index for employee_details department lookup
        if (!$this->indexExists('employee_details', 'idx_employee_department')) {
            Schema::table('employee_details', function (Blueprint $table) {
                $table->index('department_id', 'idx_employee_department');
            });
        }
        if (!$this->indexExists('employee_details', 'idx_employee_position')) {
            Schema::table('employee_details', function (Blueprint $table) {
                $table->index('position_id', 'idx_employee_position');
            });
        }

        // Add index for tasks
        if (!$this->indexExists('tasks', 'idx_task_status')) {
            Schema::table('tasks', function (Blueprint $table) {
                $table->index('status', 'idx_task_status');
            });
        }
        if (!$this->indexExists('tasks', 'idx_task_project')) {
            Schema::table('tasks', function (Blueprint $table) {
                $table->index('project_id', 'idx_task_project');
            });
        }

        // Add index for events
        if (!$this->indexExists('events', 'idx_event_department')) {
            Schema::table('events', function (Blueprint $table) {
                $table->index('target_department_id', 'idx_event_department');
            });
        }
        if (!$this->indexExists('events', 'idx_event_start_date')) {
            Schema::table('events', function (Blueprint $table) {
                $table->index('start_date', 'idx_event_start_date');
            });
        }
    }

    /**
     * Check if an index exists on a table
     */
    private function indexExists(string $table, string $index): bool
    {
        $connection = Schema::getConnection();
        $database = $connection->getDatabaseName();

        $result = $connection->select(
            "SELECT COUNT(*) as count FROM information_schema.statistics
             WHERE table_schema = ? AND table_name = ? AND index_name = ?",
            [$database, $table, $index]
        );

        return $result[0]->count > 0;
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropIndex('idx_employee_attendance_date');
            $table->dropIndex('idx_attendance_status');
        });

        Schema::table('tickets', function (Blueprint $table) {
            $table->dropIndex('idx_ticket_status_priority');
            $table->dropIndex('idx_ticket_department');
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->dropIndex('idx_project_status_department');
        });

        Schema::table('employee_details', function (Blueprint $table) {
            $table->dropIndex('idx_employee_department');
            $table->dropIndex('idx_employee_position');
        });

        Schema::table('tasks', function (Blueprint $table) {
            $table->dropIndex('idx_task_status');
            $table->dropIndex('idx_task_project');
        });

        Schema::table('events', function (Blueprint $table) {
            $table->dropIndex('idx_event_department');
            $table->dropIndex('idx_event_start_date');
        });
    }
};
