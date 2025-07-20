<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('api_keys', function (Blueprint $table) {
            $table->id();
            $table->string('key_name');
            $table->text('description')->nullable();
            $table->string('hashed_key');
            $table->enum('permissions', ['read-only', 'read-write']);
            $table->text('allowed_ips')->nullable();
            $table->integer('rate_limit')->default(100);
            $table->json('access_logs')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('api_keys');
    }
};