<?php

use App\Models\TransactionDocumentType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transaction_document_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        TransactionDocumentType::insert(
            [
                'name' => 'Акт приема передачи'
            ],
            [
                'name' => 'Договор аренды'
            ]
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('transaction_document_types');
    }
};
