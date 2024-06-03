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

        Schema::table('user_statuses', function (Blueprint $table) {
            $table->bigInteger('id')->change();
            $table->dropPrimary();
        });

        $userStatusesFromOldDb = DB::connection('oldDatabase')->table('users_statuses')->get();

        $userStatusesFromOldDbArray = [];

        foreach ($userStatusesFromOldDb as $status) {
            $userStatusesFromOldDbArray[] = [
                'id' => $status->id,
                'name' => $status->name
            ];
        }

        \App\Models\UserStatus::insert($userStatusesFromOldDbArray);

        Schema::table('user_statuses', function (Blueprint $table) use ($userStatusesFromOldDb) {
            $idStartsWith = $userStatusesFromOldDb->last()->id + 1;
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
