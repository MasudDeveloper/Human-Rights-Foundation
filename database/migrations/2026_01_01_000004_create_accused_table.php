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
        if (!Schema::hasTable('accused')) {
            Schema::create('accused', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('complaint_id')->nullable();
                $table->string('name', 100)->nullable();
                $table->integer('age')->nullable();
                $table->string('father_name', 100)->nullable();
                $table->text('address')->nullable();
                $table->string('phone', 20)->nullable();

                $table->foreign('complaint_id')->references('id')->on('complaints')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accused');
    }
};
