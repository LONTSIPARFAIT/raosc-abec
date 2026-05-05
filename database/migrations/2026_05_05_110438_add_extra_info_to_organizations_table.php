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
        Schema::table('organizations', function (Blueprint $table) {
            $table->string('presentation_doc')->nullable()->after('description');
            $table->json('legal_docs')->nullable()->after('presentation_doc');
            $table->integer('member_count')->nullable()->after('legal_docs');
            
            // Responsible Info
            $table->string('responsible_name')->nullable()->after('member_count');
            $table->string('responsible_email')->nullable()->after('responsible_name');
            $table->string('responsible_phone')->nullable()->after('responsible_email');
            $table->string('responsible_photo')->nullable()->after('responsible_phone');
            $table->string('responsible_id_doc')->nullable()->after('responsible_photo');
            
            // Vice Responsible Info
            $table->string('vice_responsible_name')->nullable()->after('responsible_id_doc');
            $table->string('vice_responsible_email')->nullable()->after('vice_responsible_name');
            $table->string('vice_responsible_phone')->nullable()->after('vice_responsible_email');
            $table->string('vice_responsible_photo')->nullable()->after('vice_responsible_phone');
            $table->string('vice_responsible_id_doc')->nullable()->after('vice_responsible_photo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('organizations', function (Blueprint $table) {
            $table->dropColumn([
                'presentation_doc',
                'legal_docs',
                'member_count',
                'responsible_name',
                'responsible_email',
                'responsible_phone',
                'responsible_photo',
                'responsible_id_doc',
                'vice_responsible_name',
                'vice_responsible_email',
                'vice_responsible_phone',
                'vice_responsible_photo',
                'vice_responsible_id_doc',
            ]);
        });
    }
};
