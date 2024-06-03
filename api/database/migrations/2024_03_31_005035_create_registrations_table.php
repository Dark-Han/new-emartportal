<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('shift_id')->nullable();
            $table->bigInteger('status_id')->nullable();
            $table->string('full_name')->nullable();
            $table->string('iin')->nullable();
            $table->string('document_number')->nullable();
            $table->string('document_given_by')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->timestamp('rent_start_date')->nullable();
            $table->timestamp('rent_end_date')->nullable();
            $table->timestamp('rent_return_date')->nullable();
            $table->integer('one_day_rent_amount')->nullable();
            $table->integer('paid')->nullable();
            $table->integer('fine')->nullable();
            $table->integer('duty')->nullable();
            $table->bigInteger('shop_id')->nullable();
            $table->bigInteger('employee_id')->nullable();
            $table->bigInteger('consultant_id')->nullable();
            $table->bigInteger('client_type_id')->nullable();
            $table->bigInteger('payment_type_id')->nullable();
            $table->boolean('for_delete')->default(false);
            $table->bigInteger('delivery_type_id')->nullable();
            $table->bigInteger('delivery_man_id')->nullable();
            $table->integer('delivery_amount')->nullable();

            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
