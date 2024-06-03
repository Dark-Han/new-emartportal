<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        \App\Models\ActionType::insert([
            ['name' => 'Создание регистрации'],
            ['name' => 'Погашение долга'],
            ['name' => 'Закрытие регистрации'],
            ['name' => 'Продление регистрации']
        ]);
    }

    public function down(): void
    {
    }
};
