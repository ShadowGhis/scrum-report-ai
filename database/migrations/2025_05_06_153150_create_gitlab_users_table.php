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
        Schema::create('gitlab_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('gitlab_id'); // ID utente GitLab
            $table->string('username');
            $table->string('name')->nullable();
            $table->string('avatar_url')->nullable();
           
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['project_id', 'gitlab_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gitlab_users');
    }
};
