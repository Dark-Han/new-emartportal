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

        Schema::table('roles', function (Blueprint $table) {
            $table->bigInteger('id')->change();
            $table->dropPrimary();
        });

        $rolesFromOldDb = DB::connection('oldDatabase')->table('roles')->get();

        $rolesFromOldDbArray = [];

        foreach ($rolesFromOldDb as $roles) {
            $rolesFromOldDbArray[] = [
                'id' => $roles->id,
                'name' => $roles->name
            ];
        }

        \App\Models\Role::insert($rolesFromOldDbArray);

        Schema::table('roles', function (Blueprint $table) use ($rolesFromOldDb) {
            $idStartsWith = $rolesFromOldDb->last()->id + 1;
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
