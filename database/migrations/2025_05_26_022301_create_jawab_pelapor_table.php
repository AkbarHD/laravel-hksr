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
        Schema::create('jawab_pelapor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelapor_id')->constrained()->onDelete('cascade');
            $table->string('tindak_lanjut'); // nanti akan berbentu radio button yang pilihannya : rujukan ke klinik, bantuan hukum, dan konseling
            $table->text('catatan_tindak_lanjut'); // nanti akan berbentu radio button yang pilihannya : rujukan ke klinik, bantuan hukum, dan konseling
            $table->integer('status')->default(0); // 0 : dalam proses, 1 selesai
            $table->char('isdelete', 1)->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jawab_pelapor');
    }
};
