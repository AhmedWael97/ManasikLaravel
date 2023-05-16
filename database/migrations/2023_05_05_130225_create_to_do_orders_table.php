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
        Schema::create('to_do_orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('executer_id');
            $table->bigInteger('order_detail_id');
            $table->boolean('is_confirmed')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('to_do_orders');
    }
};
