<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bill', function (Blueprint $table) {
            $table->id();
            $table->string('kode_bill')->nullable();

            $table->foreignId('penghuni_id')->constrained('penghuni')->onUpdate('cascade')->onDelete('cascade');
            $table->string('nik')->nullable();
            $table->string('tanggal_bill')->nullable();
            $table->string('bulan_bill')->nullable();
            $table->string('tahun_bill')->nullable();
            $table->integer('jumlah_bill')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('bill');
    }
}
