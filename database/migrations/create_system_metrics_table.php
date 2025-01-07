<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSystemMetricsTable extends Migration
{
    public function up()
    {
        Schema::create('system_metrics', function (Blueprint $table) {
            $table->id();
            $table->enum('metric_type', ['storage', 'cpu', 'memory', 'database']);
            $table->integer('value');
            $table->timestamp('recorded_at')->useCurrent();
        });
    }

    public function down()
    {
        Schema::dropIfExists('system_metrics');
    }
}
