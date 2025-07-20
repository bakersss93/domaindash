<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ssl_services', function (Blueprint $table) {
            $table->id();
            $table->string('certificate_name');
            $table->foreignId('customer_id')->nullable()->constrained('users')->onDelete('set null');
            $table->date('expiration_date');
            $table->json('details');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ssl_services');
    }
};
