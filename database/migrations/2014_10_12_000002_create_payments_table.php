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
        Schema::create('payments', function (Blueprint $table) {
            $table->unsignedInteger("id")->autoIncrement();
            $table->string('payment_method');
            $table->string('total value');
            $table->string('payment_date');
            $table->unsignedInteger('register_id');
            $table->timestamps();
            $table->foreign('register_id')->references('id')->on('registrations');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
