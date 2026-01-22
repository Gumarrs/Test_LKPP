<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lppbjs', function (Blueprint $table) {
            $table->id();
            // Perhatikan titik koma (;) di ujung baris ini
            $table->string('nama_lppbj'); 
            
            $table->enum('kriteria', ['Pemerintah', 'Non-Pemerintah']);
            $table->enum('kategori', ['A', 'B']);
            $table->date('tanggal_mulai');
            $table->date('masa_berlaku');
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
        Schema::dropIfExists('lppbjs');
    }
};