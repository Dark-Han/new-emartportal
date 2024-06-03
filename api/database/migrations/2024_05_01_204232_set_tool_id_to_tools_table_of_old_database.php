<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        if (\Illuminate\Support\Facades\App::environment() !== 'local') {
            return;
        }
        $toolIdExist = \Illuminate\Support\Facades\DB::connection('oldDatabase')
            ->select(
                "SELECT *
FROM information_schema.columns
WHERE table_name = 'tovary'
AND column_name = 'tool_id';"
            );

        if (empty($toolIdExist)) {
            \Illuminate\Support\Facades\DB::connection('oldDatabase')
                ->statement(
                    'ALTER TABLE tovary ADD COLUMN tool_id INT'
                );
        }

        \Illuminate\Support\Facades\DB::connection('oldDatabase')
            ->statement(
                'update tovary
             set tool_id=(select sklad.id
             from sklad
                      inner join instrumenty i on sklad.type = i.id
             where i.name = tovary.tovar
               and sklad.id_shop = (select regist.id_shop from regist where id = tovary.id_reg))'
            );
    }

    public function down(): void
    {
    }
};
