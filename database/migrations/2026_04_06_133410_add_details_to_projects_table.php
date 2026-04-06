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
        Schema::table('projects', function (Blueprint $table) {
            $table->foreignId('organization_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('type')->default('projet'); // projet, benevolat
            $table->text('description');
            $table->string('cover_image')->nullable();
            $table->string('status')->default('active'); // active, completed
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropForeign(['organization_id']);
            $table->dropColumn(['organization_id', 'title', 'type', 'description', 'cover_image', 'status']);
        });
    }
};
