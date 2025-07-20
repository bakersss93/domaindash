<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiskSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('disk_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('warning_threshold')->default(80);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('disk_settings');
    }
}
