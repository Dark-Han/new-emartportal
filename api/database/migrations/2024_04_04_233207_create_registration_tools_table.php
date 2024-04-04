<?php

use App\Models\Registration;
use App\Models\Tool;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('registration_tools', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Registration::class);
            $table->foreignIdFor(Tool::class);
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registration_tools');
    }
};
