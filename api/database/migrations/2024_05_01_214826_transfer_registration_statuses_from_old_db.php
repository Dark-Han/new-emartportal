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

        Schema::table('registration_statuses', function (Blueprint $table) {
            $table->bigInteger('id')->change();
            $table->dropPrimary();
        });

        $statusesFromOldDb = DB::connection('oldDatabase')->table('status')->get();

        $statusesFromOldDbArray = [];

        foreach ($statusesFromOldDb as $status) {
            $statusesFromOldDbArray[] = [
                'id' => $status->id,
                'name' => $status->name
            ];
        }

        \App\Models\RegistrationStatus::insert($statusesFromOldDbArray);

        Schema::table('registration_statuses', function (Blueprint $table) use ($statusesFromOldDb) {
            $idStartsWith = $statusesFromOldDb->last()->id + 1;
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
