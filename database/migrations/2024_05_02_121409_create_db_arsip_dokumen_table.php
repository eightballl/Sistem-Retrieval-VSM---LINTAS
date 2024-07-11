<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDbArsipDokumenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('db_arsip_dokumen', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama_dokumen');
            $table->string('nomor_dokumen');
            $table->integer('jenis_dokumen');
            $table->string('kategori');
            $table->text('deskripsi');
            $table->text('keyword');
            $table->string('file');
            $table->string('id_divisi');
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
        Schema::dropIfExists('db_arsip_dokumen');
    }
}
