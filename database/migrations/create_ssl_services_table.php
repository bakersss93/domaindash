<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSslServicesTable extends Migration
{
    public function up()
    {
        Schema::create('ssl_services', function (Blueprint $table) {
            $table->id();
            $table->string('certificate_name');
            $table->foreignId('client_id')->nullable()->constrained('clients')->onDelete('set null');
            $table->date('expiration_date');
            $table->json('details');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ssl_services');
    }
}
