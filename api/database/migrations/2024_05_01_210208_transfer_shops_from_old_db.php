<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (\Illuminate\Support\Facades\App::environment() !== 'local') {
            return;
        }
        Schema::table('shops', function (Blueprint $table) {
            $table->bigInteger('id')->change();
            $table->dropPrimary();
        });

        $shopsFromOldDb = DB::connection('oldDatabase')->table('shops')->get();

        $shopsFromOldDbArray = [];

        foreach ($shopsFromOldDb as $shop) {
            $shopsFromOldDbArray[] = [
                'id' => $shop->id,
                'address' => $shop->address
            ];
        }

        \App\Models\Shop::insert($shopsFromOldDbArray);

        Schema::table('shops', function (Blueprint $table) use ($shopsFromOldDb) {
            $idStartsWith = $shopsFromOldDb->last()->id + 1;
            $table->id()->startingValue($idStartsWith)->change();
        });
    }

    public function down(): void
    {
        Schema::table('new', function (Blueprint $table) {
            //
        });
    }
};
