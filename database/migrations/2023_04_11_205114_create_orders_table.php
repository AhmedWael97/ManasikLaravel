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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->bigInteger('main_service_id')->nullable();
            $table->bigInteger('payment_type_id')->nullable();
            $table->bigInteger('payment_status_id')->nullable();
            $table->string('order_code');
            $table->bigInteger('order_status_id')->nullable();
            $table->double('price')->default(0);
            $table->bigInteger('currency_id')->nullable();
            $table->boolean('is_from_wallet')->defaul(0);
            $table->bigInteger('prize_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
