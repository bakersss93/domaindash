<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('smtp_settings', function (Blueprint $table) {
            $table->id();
            $table->string('send_from_email');
            $table->string('smtp_server');
            $table->integer('smtp_port');
            $table->string('smtp_username');
            $table->string('smtp_password');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('smtp_settings');
    }
};
