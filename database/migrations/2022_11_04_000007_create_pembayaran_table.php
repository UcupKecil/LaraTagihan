<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembayaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pembayaran')->nullable();
            $table->foreignId('petugas_id')->constrained('petugas')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('penghuni_id')->constrained('penghuni')->onUpdate('cascade')->onDelete('cascade');
            $table->string('nik')->nullable();
            $table->string('tanggal_bayar')->nullable();
            $table->string('bulan_bayar')->nullable();
            $table->string('tahun_bayar')->nullable();
            $table->integer('jumlah_bayar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pembayaran');
    }
}
