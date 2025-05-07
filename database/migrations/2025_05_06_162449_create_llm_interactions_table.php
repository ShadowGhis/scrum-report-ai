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
        Schema::create('llm_interactions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('report_id')->constrained('reports')->onDelete('cascade');

            $table->longText('prompt');
            $table->longText('response')->nullable();
            $table->string('model_used')->default('gpt-4');
            $table->unsignedInteger('token_usage')->nullable();
            $table->float('temperature')->nullable();
            $table->text('error')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('llm_interactions');
    }
};
