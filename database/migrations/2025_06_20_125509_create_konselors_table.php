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
        Schema::create('konselors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Foreign key ke users table
            $table->string('gambar_konselor')->nullable();
            $table->enum('jenis_konselor', ['Konselor HKSR', 'Konselor Mental', 'Konselor Sebaya']);
            $table->text('deskripsi');
            $table->time('jam_aktif_awal');
            $table->time('jam_aktif_akhir');
            $table->tinyInteger('is_delete')->default(0);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('konselors');
    }
};
