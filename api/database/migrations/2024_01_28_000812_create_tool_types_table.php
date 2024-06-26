<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tool_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('selling_price');
            $table->integer('rental_price');
            $table->integer('discount_price');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tool_types');
    }
};
