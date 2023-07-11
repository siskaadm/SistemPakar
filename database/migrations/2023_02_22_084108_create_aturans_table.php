<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAturansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aturans', function (Blueprint $table) {
            $table->string('kode_aturan', 4)->primary();
            $table->text('kode_gejala', 4);
            $table->string('kode_kerusakan');
            $table->timestamps();
            
            $table->foreign('kode_kerusakan')
            ->references('kode_kerusakan')
            ->on('kerusakans')
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
        Schema::dropIfExists('aturans');
    }
}
