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
        Schema::table('members', function (Blueprint $table) {
            if (!Schema::hasColumn('members', 'nid_front_image')) {
                $table->string('nid_front_image', 255)->nullable()->after('id_card_photo');
            }
            if (!Schema::hasColumn('members', 'nid_back_image')) {
                $table->string('nid_back_image', 255)->nullable()->after('nid_front_image');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            if (Schema::hasColumn('members', 'nid_front_image')) {
                $table->dropColumn('nid_front_image');
            }
            if (Schema::hasColumn('members', 'nid_back_image')) {
                $table->dropColumn('nid_back_image');
            }
        });
    }
};
