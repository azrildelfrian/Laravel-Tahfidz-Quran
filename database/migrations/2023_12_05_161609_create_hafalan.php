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
        Schema::create('hafalan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('surat_id')->constrained('surat');
            $table->foreignId('surat_id_2')->constrained('surat');
            $table->foreignId('diperiksa_oleh')->nullable()->constrained('users');
            $table->integer('ayat_setoran_1');
            $table->integer('ayat_setoran_2');
            $table->string('file_hafalan')->nullable();
            $table->date('tanggal_hafalan')->nullable();
            $table->timestamp('diperiksa_pada')->nullable();
            $table->enum('kelancaran', ['lancar', 'agak lancar', 'kurang lancar', 'tidak lancar','belum diperiksa'])->nullable();
            $table->enum('status', ['sudah diperiksa', 'sedang diperiksa', 'belum diperiksa']);
            $table->enum('ulang', ['mengulang', 'tidak', 'belum diperiksa'])->nullable();
            $table->text('catatan_teks')->nullable();
            $table->string('catatan_suara')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hafalan');
    }
};
