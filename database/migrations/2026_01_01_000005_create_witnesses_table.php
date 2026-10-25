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
        if (!Schema::hasTable('witnesses')) {
            Schema::create('witnesses', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('complaint_id');
                $table->string('witness_no', 50)->nullable();
                $table->string('name', 255)->nullable();
                $table->integer('age')->nullable();
                $table->string('father_name', 255)->nullable();
                $table->string('address', 255)->nullable();
                $table->string('phone_number', 20)->nullable();

                $table->foreign('complaint_id')->references('id')->on('complaints')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('witnesses');
    }
};
