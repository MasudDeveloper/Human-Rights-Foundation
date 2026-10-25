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
        if (!Schema::hasTable('complaints')) {
            Schema::create('complaints', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('user_id');
                $table->string('name', 255);
                $table->integer('age');
                $table->string('father_name', 255)->nullable();
                $table->string('mother_name', 255)->nullable();
                $table->string('spouse_name', 255)->nullable();
                $table->string('village', 255)->nullable();
                $table->string('post_office', 255)->nullable();
                $table->string('thana', 255)->nullable();
                $table->string('district', 255)->nullable();
                $table->string('phone_number', 20);
                $table->string('complaint_type', 255);
                $table->text('details')->nullable();
                $table->string('complainant_name', 255)->nullable();
                $table->string('complainant_phone', 20)->nullable();
                $table->string('signature', 255)->nullable();
                $table->enum('status', ['pending', 'approved', 'rejected', 'investigated', 'complete'])->default('pending');
                $table->string('pdf_url', 255)->nullable();
                $table->string('payment_amount', 100)->default('0');
                $table->string('payment_gateway', 100)->nullable();
                $table->string('payment_number', 100)->nullable();
                $table->string('transaction_id', 100)->nullable();
                $table->text('reject_reason')->nullable();
                $table->string('time', 100)->nullable();
                $table->timestamps();

                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
