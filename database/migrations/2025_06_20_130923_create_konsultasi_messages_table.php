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
        Schema::create('konsultasi_messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('session_id'); // Mengacu ke sesi konsultasi
            $table->unsignedBigInteger('sender_id');  // Bisa user atau konselor
            $table->text('message');
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();

            $table->foreign('session_id')->references('id')->on('konsultasi_sessions')->onDelete('cascade');
            $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('konsultasi_messages');
    }
};
