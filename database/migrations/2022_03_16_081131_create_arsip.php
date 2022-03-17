<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArsip extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arsips', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('perusahaan_id')->unsigned();
            $table->string('nama');
            $table->date('tanggal');
            $table->string('tahun_pajak', 4);
            $table->text('keterangan');
            $table->integer('baris');
            $table->integer('sisi');
            $table->integer('rak');
            $table->integer('lantai');
            $table->integer('box');
            $table->text('url');
            $table->smallInteger('status');
            $table->timestamps();
            $table->foreign('perusahaan_id')->references('id')->on('perusahaans');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('arsips');
    }
}
