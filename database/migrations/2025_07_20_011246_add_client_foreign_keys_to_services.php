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
        Schema::table('domains', function (Blueprint $table) {
            $table->foreignId('client_id')->nullable()->after('domain_name')->constrained()->onDelete('set null');
            $table->dropForeign(['customer_id']);
            $table->dropColumn('customer_id');
        });

        Schema::table('hosting_services', function (Blueprint $table) {
            $table->foreignId('client_id')->nullable()->after('service_name')->constrained()->onDelete('set null');
            $table->dropForeign(['customer_id']);
            $table->dropColumn('customer_id');
        });

        Schema::table('ssl_services', function (Blueprint $table) {
            $table->foreignId('client_id')->nullable()->after('certificate_name')->constrained()->onDelete('set null');
            $table->dropForeign(['customer_id']);
            $table->dropColumn('customer_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ssl_services', function (Blueprint $table) {
            $table->foreignId('customer_id')->nullable()->constrained('users')->onDelete('set null');
            $table->dropForeign(['client_id']);
            $table->dropColumn('client_id');
        });

        Schema::table('hosting_services', function (Blueprint $table) {
            $table->foreignId('customer_id')->nullable()->constrained('users')->onDelete('set null');
            $table->dropForeign(['client_id']);
            $table->dropColumn('client_id');
        });

        Schema::table('domains', function (Blueprint $table) {
            $table->foreignId('customer_id')->nullable()->constrained('users')->onDelete('set null');
            $table->dropForeign(['client_id']);
            $table->dropColumn('client_id');
        });
    }
};
