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
        Schema::create('waiting_list', function (Blueprint $table) {
            $table->unsignedInteger("id")->autoIncrement();
            $table->date("registration_date");
            $table->unsignedInteger('assitant_id');
            $table->unsignedInteger('event_id');
            $table->timestamps();
            $table->foreign('assitant_id')->references('id')->on('assistants');
            $table->foreign('event_id')->references('id')->on('events');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('waiting_list');
    }
};
