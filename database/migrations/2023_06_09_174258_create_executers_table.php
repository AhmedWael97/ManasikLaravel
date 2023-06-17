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
        Schema::create('executers', function (Blueprint $table) {
            $table->id();
            $table->string('_token')->nullable();
            $table->string('name');
            $table->string('name_ar');
            $table->tinyInteger('gender')->default(0);
            $table->string('birthdate')->nullable();
            $table->string('id_number')->nullable();
            $table->string('work_capacity')->nullable();
            $table->string('instituation_name')->nullable();
            $table->tinyInteger('job_id')->default(0);
            $table->tinyInteger('country_id')->default(0);
            $table->tinyInteger('nationality_id')->default(0);
            $table->tinyInteger('lang_id')->default(0);
            $table->string('place_of_residence_id')->nullable();
            $table->string('is_active')->default(0);
            $table->string('is_confirmed_executer')->default(0);
            $table->string('photo_path')->nullable();
            $table->string('bank_account_no')->nullable();
            $table->string('bank_branch')->nullable();
            $table->string('bank')->nullable();
            $table->string('account_number')->nullable();
            $table->string('friend_account_number')->nullable();
            $table->string('government_id_path')->nullable();
            $table->string('iban')->nullable();
            $table->string('sos_status')->nullable();
            $table->string('sos_start_date')->nullable();
            $table->tinyInteger('is_allow_notification')->default(0);
            $table->string('known_by')->nullable();
            $table->string('address')->nullable();
            $table->string('activity_license_image_path')->nullable();
            $table->string('activity_license_number')->nullable();
            $table->string('agency_address')->nullable();
            $table->string('certificate_registration_tax')->nullable();
            $table->string('chamber_of_commerce_registration')->nullable();
            $table->string('commercial_registration_image_path')->nullable();
            $table->string('commercial_registration_no')->nullable();
            $table->string('executer_area')->nullable();
            $table->string('tax_registration_number')->nullable();
            $table->string('user_mange_name')->nullable();
            $table->string('reject_reason')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone')->unique();
            $table->timestamp('phone_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('executers');
    }
};
