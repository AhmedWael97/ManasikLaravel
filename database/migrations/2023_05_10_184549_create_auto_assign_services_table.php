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
        Schema::create('auto_assign_services', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('executer_id');
            $table->bigInteger('service_id')->nullable();
            $table->bigInteger('maxCount')->default(0);
            $table->boolean('auto_assign')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auto_assign_services');
    }
};
