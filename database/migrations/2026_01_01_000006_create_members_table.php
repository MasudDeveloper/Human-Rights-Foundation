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
        if (!Schema::hasTable('members')) {
            Schema::create('members', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('user_id');

                // ID Card Fields
                $table->string('member_id_card_number', 50)->nullable()->index();
                $table->string('id_card_photo', 255)->nullable();
                $table->date('id_card_issue_date')->nullable();
                $table->date('id_card_expiry_date')->nullable();
                $table->enum('id_card_status', ['not_generated', 'generated', 'suspended'])->default('not_generated');

                // Member Bio & Designation
                $table->string('post_name', 255)->nullable();
                $table->string('bangla_name', 255)->nullable();
                $table->string('english_name', 255)->nullable();
                $table->string('father_name', 255)->nullable();
                $table->string('mother_name', 255)->nullable();

                // Present Address
                $table->string('village', 255)->nullable();
                $table->string('post_office', 255)->nullable();
                $table->string('thana', 255)->nullable();
                $table->string('district', 255)->nullable();

                // Permanent Address
                $table->string('village2', 255)->nullable();
                $table->string('post_office2', 255)->nullable();
                $table->string('thana2', 255)->nullable();
                $table->string('district2', 255)->nullable();

                // Personal Info
                $table->string('education', 255)->nullable();
                $table->string('date_of_birth', 255)->nullable();
                $table->string('nid', 100)->nullable();
                $table->string('blood_group', 50)->nullable();
                $table->string('jonmodag', 255)->nullable();
                $table->string('current_job', 255)->nullable();
                $table->string('nationality', 100)->nullable()->default('Bangladeshi');
                $table->string('passport_number', 100)->nullable();
                $table->string('marital_status', 50)->nullable();
                $table->string('spouse_name', 255)->nullable();
                $table->string('spouse_number', 100)->nullable();
                $table->string('religion', 100)->nullable();

                // Contact & Social
                $table->string('phone_number', 100)->nullable();
                $table->string('office_number', 100)->nullable();
                $table->string('facebook_id', 255)->nullable();
                $table->string('email', 255)->nullable();
                $table->string('reference_name', 255)->nullable();
                $table->string('youtube_id', 255)->nullable();
                $table->string('reference_post', 255)->nullable();
                $table->string('signature', 255)->nullable();

                // Status & Payment
                $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
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
        Schema::dropIfExists('members');
    }
};
