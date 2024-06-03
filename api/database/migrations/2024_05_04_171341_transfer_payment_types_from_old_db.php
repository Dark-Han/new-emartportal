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

        Schema::table('payment_types', function (Blueprint $table) {
            $table->bigInteger('id')->change();
            $table->dropPrimary();
        });

        $paymentTypesFromOldDb = DB::connection('oldDatabase')->table('payment_type')->get();

        $paymentTypesFromOldDbArray = [];

        foreach ($paymentTypesFromOldDb as $paymentType) {
            $paymentTypesFromOldDbArray[] = [
                'id' => $paymentType->id,
                'name' => $paymentType->name
            ];
        }

        \App\Models\PaymentType::insert($paymentTypesFromOldDbArray);

        Schema::table('payment_types', function (Blueprint $table) use ($paymentTypesFromOldDb) {
            $idStartsWith = $paymentTypesFromOldDb->last()->id + 1;
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
