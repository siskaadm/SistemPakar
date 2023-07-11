<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKerusakansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kerusakans', function (Blueprint $table) {
            $table->string('kode_kerusakan', 4)->primary();
            $table->string('nama_kerusakan', 50);
            $table->string('kode_kategori', 4);
            $table->timestamps();
            
            $table->foreign('kode_kategori')
            ->references('kode_kategori')
            ->on('kategori_solusis')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kerusakans');
    }
}
