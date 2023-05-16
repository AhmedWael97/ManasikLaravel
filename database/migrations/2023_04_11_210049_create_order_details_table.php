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
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_id');
            $table->bigInteger('service_id')->nullable();
            $table->bigInteger('order_status_id')->nullable();
            $table->string('full_name');
            $table->bigInteger('executer_id')->nullable();
            $table->integer('no_of_kfara')->nullable();
            $table->string('execution_date')->nullable();
            $table->string('required_date')->nullable();
            $table->double('price')->nullable();
            $table->double('executer_price')->nullable();
            $table->integer('currency_id')->nullable();
            $table->integer('purpose_hag_id')->nullable();
            $table->integer('kfarat_choice_id')->nullable();
            $table->boolean('is_confirmed')->default(0);
            $table->integer('ref_order_detail_id')->nullable();
            $table->boolean('is_cached')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
