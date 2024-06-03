<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        if (\Illuminate\Support\Facades\App::environment() !== 'local') {
            return;
        }
        $deletedExist = \Illuminate\Support\Facades\DB::connection('oldDatabase')
            ->select(
                "SELECT *
FROM information_schema.columns
WHERE table_name = 'instrumenty'
AND column_name = 'deleted';"
            );

        if (empty($deletedExist)) {
            \Illuminate\Support\Facades\DB::connection('oldDatabase')
                ->statement(
                    'ALTER TABLE instrumenty ADD COLUMN deleted BOOLEAN'
                );
        }

        $deletedToolTypes = DB::connection('oldDatabase')
            ->select(
                'select
                            tovar as name
                        from tovary
                        left join instrumenty on tovary.tovar=instrumenty.name
                        where instrumenty.id is null
                        group by tovar'
            );

        foreach ($deletedToolTypes as $toolType) {
            DB::connection('oldDatabase')
                ->table('instrumenty')
                ->updateOrInsert(['name' => $toolType->name],
                    [
                        'cena' => 0,
                        'cena_arendy' => 0,
                        'skidka' => 0,
                        'deleted' => true
                    ]);
        }
    }

    public function down(): void
    {
    }
};
