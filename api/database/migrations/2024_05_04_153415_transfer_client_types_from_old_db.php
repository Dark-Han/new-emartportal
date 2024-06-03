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

        Schema::table('client_types', function (Blueprint $table) {
            $table->bigInteger('id')->change();
            $table->dropPrimary();
        });

        $clientTypesFromOldDb = DB::connection('oldDatabase')->table('client_types')->get();

        $clientTypesFromOldDbArray = [];

        foreach ($clientTypesFromOldDb as $clientType) {
            $clientTypesFromOldDbArray[] = [
                'id' => $clientType->id,
                'name' => $clientType->name
            ];
        }

        \App\Models\ClientType::insert($clientTypesFromOldDbArray);

        Schema::table('client_types', function (Blueprint $table) use ($clientTypesFromOldDb) {
            $idStartsWith = $clientTypesFromOldDb->last()->id + 1;
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
