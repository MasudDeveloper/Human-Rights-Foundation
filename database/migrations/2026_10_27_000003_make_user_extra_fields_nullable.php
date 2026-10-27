<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Use raw SQL so it works seamlessly on MySQL without requiring doctrine/dbal
        try {
            DB::statement("ALTER TABLE `users` 
                MODIFY `nid_number` VARCHAR(100) NULL, 
                MODIFY `date_of_birth` VARCHAR(100) NULL, 
                MODIFY `profile_image` VARCHAR(255) NULL, 
                MODIFY `nid_front_image` VARCHAR(255) NULL, 
                MODIFY `nid_back_image` VARCHAR(255) NULL");
        } catch (\Throwable $e) {
            // Fallback for sqlite or different drivers
            Schema::table('users', function (Blueprint $table) {
                $table->string('nid_number', 100)->nullable()->change();
                $table->string('date_of_birth', 100)->nullable()->change();
                $table->string('profile_image', 255)->nullable()->change();
                $table->string('nid_front_image', 255)->nullable()->change();
                $table->string('nid_back_image', 255)->nullable()->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
