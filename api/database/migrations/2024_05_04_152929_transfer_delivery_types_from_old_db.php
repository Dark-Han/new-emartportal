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

        Schema::table('delivery_types', function (Blueprint $table) {
            $table->bigInteger('id')->change();
            $table->dropPrimary();
        });

        $deliveryTypesFromOldDb = DB::connection('oldDatabase')->table('delivery_type')->get();

        $deliveryTypeFromOldDbArray = [];

        foreach ($deliveryTypesFromOldDb as $deliveryType) {
            $deliveryTypeFromOldDbArray[] = [
                'id' => $deliveryType->id,
                'name' => $deliveryType->name
            ];
        }

        \App\Models\DeliveryType::insert($deliveryTypeFromOldDbArray);

        Schema::table('delivery_types', function (Blueprint $table) use ($deliveryTypesFromOldDb) {
            $idStartsWith = $deliveryTypesFromOldDb->last()->id + 1;
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
