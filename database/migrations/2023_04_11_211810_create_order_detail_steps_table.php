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
        Schema::create('order_detail_steps', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('detail_id');
            $table->bigInteger('service_step_id');
            $table->string('start_in')->nullable();
            $table->string('end_in')->nullable();
            $table->bigInteger('step_status_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_detail_steps');
    }
};
