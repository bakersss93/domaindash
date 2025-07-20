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
        Schema::create('hosting_services', function (Blueprint $table) {
            $table->id();
            $table->string('service_name');
            $table->foreignId('customer_id')->nullable()->constrained('users')->onDelete('set null');
            $table->integer('disk_usage')->default(0);
            $table->integer('database_usage')->default(0);
            $table->integer('disk_space_threshold')->default(80);
            $table->string('hosting_plan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hosting_services');
    }
};
