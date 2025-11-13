<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contact_contents', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('subtitle')->nullable();
            $table->json('socials')->nullable(); // github, linkedin, email
            $table->json('form')->nullable(); // form placeholders
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_contents');
    }
};
