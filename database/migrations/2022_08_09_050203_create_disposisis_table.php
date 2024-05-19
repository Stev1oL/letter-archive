<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDisposisisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disposisis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('letter_id');
            $table->string('lampiran');
            $table->string('status');
            $table->string('sifat');
            $table->string('petunjuk')->nullable();
            $table->text('catatan_rektor')->nullable();
            $table->date('tgl_selesai')->nullable();
            $table->string('kepada')->nullable();
            $table->text('petunjuk_kpd_1')->nullable();
            $table->date('tgl_selesai_2')->nullable();
            $table->string('penerima_2')->nullable();
            $table->enum('check_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->string('letter_file')->nullable();
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
        Schema::dropIfExists('disposisis');
    }
}
