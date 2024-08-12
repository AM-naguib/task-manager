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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string("name")->nullable();
            $table->text("summary")->nullable();
            $table->string("status")->nullable();
            $table->string("deadline")->nullable();
            $table->string("priority")->nullable();
            $table->text("description")->nullable();
            $table->foreignId("project_id")->nullable()->constrained("projects")->onDelete("cascade");
            $table->foreignId("created_by")->constrained("users")->onDelete("cascade");
            // $table->foreignId("assigned_to")->nullable()->constrained("users")->onDelete("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
