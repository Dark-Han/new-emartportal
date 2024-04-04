<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->bigInteger('id');
            $table->integer('id_smena')->nullable();
            $table->boolean('cher_spis')->nullable();
            $table->string('fio')->nullable();
            $table->string('iin')->nullable();
            $table->string('nom_udas')->nullable();
            $table->string('vydano')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('extra_information')->nullable();
            $table->string('akt_prim')->nullable();
            $table->string('dog_aren')->nullable();
            $table->string('delivery_type')->nullable();
            $table->string('date_st')->nullable();
            $table->string('date_en')->nullable();
            $table->string('date_sd')->nullable();
            $table->string('delivery_man')->nullable();
            $table->string('id_shop')->nullable();
            $table->string('user_id_role')->nullable();
            $table->string('payment_type_id')->nullable();
            $table->string('consultant_id')->nullable();
            $table->string('client_type_id')->nullable();
            $table->string('one_day_payment')->nullable();
            $table->string('remove')->nullable();
            $table->string('removed')->nullable();
            $table->string('shtraf')->nullable();
            $table->string('delivery_payment')->nullable();
            $table->string('status')->nullable();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
