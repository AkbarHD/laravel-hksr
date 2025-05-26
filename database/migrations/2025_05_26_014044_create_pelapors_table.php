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
        Schema::create('pelapors', function (Blueprint $table) {
            $table->id();
            $table->string('id_pelapor');
            $table->string('judul', 100);
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->text('deskripsi');
            $table->text('catatan')->nullable(); // bisa catatan penolakan, atau bisa catatan verifikasi
            $table->string('bukti')->nullable(); // bukti berupda gambar, atau pdf
            $table->string('nama', 100)->nullable();  // jika pencet anonim, ini tidak terisi
            $table->string('no_hp', 100)->nullable(); // jika pencet anonim, ini tidak terisi
            $table->string('email', 100)->nullable(); // jika pencet anonim, ini tidak terisi
            $table->integer('status'); // status : 0 : Menunggu verifikasi,  1 : di proses (di verifikasi), 2 : di tolak
            $table->char('isdelete', 1)->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelapors');
    }
};
