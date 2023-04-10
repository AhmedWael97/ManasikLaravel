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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name_en');
            $table->string('name_ar');
            $table->string('photo')->nullable();
            $table->integer('max_limit')->default(-1);
            $table->double('price')->default(0);
            $table->double('executer_price')->default(0);
            $table->integer('earning_points');
            $table->integer('max_limit_by_order')->default(-1);
            $table->bigInteger('parent_id')->nullable();
            $table->string('actual_date')->nullable();
            $table->integer('no_of_childs')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
