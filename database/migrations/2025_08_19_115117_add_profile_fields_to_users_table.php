<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('title', 150)->nullable()->after('name');
            $table->text('bio')->nullable()->after('title');
            $table->string('github_url', 255)->nullable()->after('bio');
            $table->string('linkedin_url', 255)->nullable()->after('github_url');
            $table->string('twitter_url', 255)->nullable()->after('linkedin_url');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['title', 'bio', 'github_url', 'linkedin_url', 'twitter_url']);
        });
    }
};


