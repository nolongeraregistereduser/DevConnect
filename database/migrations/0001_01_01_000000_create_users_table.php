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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            // profile user enrechi 
            $table->text('bio')->nullable();
            $table->string('profile_picture')->nullable();
            $table->string('location')->nullable();
            $table->string('website')->nullable();

            // json tables 

            $table->json('skills')->nullable(); // Compétences techniques
            $table->json('programming_languages')->nullable(); // Langages de programmation
            $table->json('projects')->nullable(); // Projets réalisés (titre, description, lien)
            $table->json('certifications')->nullable(); // Certifications obtenues (titre, date, organisation)

            // Liens vers les portfolios
            $table->string('github_link')->nullable();
            $table->string('gitlab_link')->nullable();

            
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
