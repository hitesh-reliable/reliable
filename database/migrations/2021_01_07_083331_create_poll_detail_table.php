<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePollDetailTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('poll_detail', function (Blueprint $table) {
            $table->id();
            $table->string('pollName', 255);
            $table->longText('pollDescription', 2048);
            $table->dateTime('pollTiming');
            $table->integer('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('poll_detail');
    }
}
