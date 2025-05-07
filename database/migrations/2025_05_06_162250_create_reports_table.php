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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();

            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // sviluppatore (report personale)
            $table->foreignId('generated_by')->nullable()->constrained('users')->onDelete('set null'); // admin/manager

            $table->enum('type', ['daily', 'weekly', 'custom'])->default('daily');
            $table->enum('generation_status', ['success', 'failed', 'in_progress'])->default('in_progress');
            $table->timestamp('generated_at')->nullable();
            $table->longText('content')->nullable();
            $table->text('prompt_used')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
