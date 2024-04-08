<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->string('address');
            $table->softDeletes();
            $table->timestamps();
        });

        $shops = \Illuminate\Support\Facades\DB::connection('oldDatabase')
            ->table('shops')
            ->get();

        foreach ($shops as $shop) {
            \App\Models\Shop::create(['id' => $shop->id, 'address' => $shop->address]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('shops');
    }
};
