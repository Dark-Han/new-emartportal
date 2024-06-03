<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('actions', function (Blueprint $table) {
            $table->bigInteger('employee_id');
            $table->bigInteger('shop_id');
        });
    }

    public function down(): void
    {
        Schema::table('actions', function (Blueprint $table) {
            $table->dropColumn('employee_id');
            $table->dropColumn('shop_id');
        });
    }
};
