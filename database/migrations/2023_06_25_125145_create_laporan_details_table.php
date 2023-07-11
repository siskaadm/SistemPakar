<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaporanDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laporan_details', function (Blueprint $table) {
            $table->id();
			$table->foreignId('laporan_id')->constrained('laporans')->onDelete('cascade');
			$table->string('kode_aturan', 4);
			$table->string('kode_kerusakan', 4);
			$table->string('kode_kategori', 4);
            $table->float('persentase');

			$table->foreign('kode_aturan')->references('kode_aturan')->on('aturans')->onDelete('cascade');
			$table->foreign('kode_kerusakan')->references('kode_kerusakan')->on('kerusakans')->onDelete('cascade');
			$table->foreign('kode_kategori')->references('kode_kategori')->on('kategori_solusis')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('laporan_details');
    }
}
