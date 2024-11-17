<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusStopTable extends Migration
{
    public function up()
{
    Schema::create('bus_stop', function (Blueprint $table) {
        $table->id();
        $table->foreignId('bus_id')->constrained();
        $table->foreignId('stop_id')->constrained();
        $table->enum('direction', ['forward', 'backward']);
        $table->timestamps();
    });
}

    public function down()
    {
        Schema::dropIfExists('bus_stop');
    }
}
