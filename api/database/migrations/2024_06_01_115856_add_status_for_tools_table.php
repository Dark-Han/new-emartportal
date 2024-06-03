<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tools', function (Blueprint $table) {
            $table->bigInteger('status_id');
            /**
             * @todo разобраться почему нельзя создать внешний ключ
             */
//            $table->foreign('status_id')->references('id')->on('tool_statuses');
        });
    }

    public function down(): void
    {
        Schema::table('tools', function (Blueprint $table) {
            $table->dropColumn('status_id');
        });
    }
};
