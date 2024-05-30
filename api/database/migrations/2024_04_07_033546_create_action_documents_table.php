<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('action_documents', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('action_id');
            $table->bigInteger('action_document_type_id');
            $table->string('path');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('action_documents');
    }
};
