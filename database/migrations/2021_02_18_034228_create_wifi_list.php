<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWifiList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wifi_list', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('ap_mac', 12)->default('000000000000');
            $table->string('client_mac', 12)->default('000000000000');
            $table->text('ssid')->nullable();
            $table->text('password')->nullable();
            $table->text('ap_vendor')->nullable();
            $table->text('hash')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wifi_list');
    }
}
