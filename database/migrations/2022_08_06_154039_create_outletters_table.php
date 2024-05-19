<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOutlettersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('letterouts', function (Blueprint $table) {
            $table->id();
            $table->string('letter_no');
            $table->string('first_number');
            $table->string('temp_number');
            $table->date('letterout_date');
            $table->string('attribute');
            $table->string('copy');
            $table->text('content');
            $table->string('regarding');
            $table->string('purpose');
            $table->string('letter_type');
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
        Schema::dropIfExists('outletters');
    }
}
