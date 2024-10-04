<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHumanResourcesTable extends Migration
{
    public function up(): void
    {
        Schema::create('human_resources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('department');
            $table->string('position'); 
            $table->string('contact_number');
            $table->string('company_email');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('human_resources');
    }
}
