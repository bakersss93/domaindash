<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('backup_settings', function (Blueprint $table) {
            $table->id();
            $table->string('sftp_server');
            $table->integer('sftp_port')->default(22);
            $table->string('sftp_username');
            $table->string('sftp_password');
            $table->integer('backup_retention')->default(5);
            $table->time('backup_time')->default('03:00:00');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('backup_settings');
    }
};
