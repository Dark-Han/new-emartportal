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

        Schema::table('tool_types', function (Blueprint $table) {
            $table->bigInteger('id')->change();
            $table->dropPrimary();
        });

        $toolTypesFromOldDb = DB::connection('oldDatabase')->table('instrumenty')->get();

        $toolTypesFromOldDbArray = [];

        foreach ($toolTypesFromOldDb as $i => $toolType) {
            $toolTypesFromOldDbArray[$i] = [
                'id' => $toolType->id,
                'name' => $toolType->name,
                'selling_price' => $toolType->cena,
                'rental_price' => $toolType->cena_arendy,
                'discount_price' => $toolType->skidka,
                'deleted_at' => null
            ];

            if ($toolType->deleted) {
                $toolTypesFromOldDbArray[$i]['deleted_at'] = now();
            }
        }

        \App\Models\ToolTypes::insert($toolTypesFromOldDbArray);

        Schema::table('tool_types', function (Blueprint $table) use ($toolTypesFromOldDb) {
            $idStartsWith = $toolTypesFromOldDb->last()->id + 1;
            $table->id()->startingValue($idStartsWith)->change();
        });
    }

    public function down(): void
    {
        Schema::table('old_db', function (Blueprint $table) {
            //
        });
    }
};
