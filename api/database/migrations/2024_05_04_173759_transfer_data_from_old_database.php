<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration {
    public function up(): void
    {
        if (\Illuminate\Support\Facades\App::environment() !== 'local') {
            return;
        }

        Schema::table('registrations', function (Blueprint $table) {
            $table->bigInteger('id')->change();
            $table->dropPrimary();
        });

        DB::connection('oldDatabase')
            ->table('regist')
            ->join('kassa', 'regist.id', '=', 'kassa.id_reg')
            ->select('*')
            ->orderBy('regist.id')
            ->chunk(2500, function (\Illuminate\Support\Collection $registrations) {
                $newRegistrations = [];
                $newActions = [];
                foreach ($registrations as $i => $registration) {
                    if (empty($registration->dop_info)) {
                        $newRegistrations[] = $this->generateNewRegistration($registration);
                        $registration->type = 1;
                        $newActions[] = $this->generateNewAction($registration);
                    } else {
                        $type = '';
                        if (stripos($registration->dop_info, 'Закрытие регистрации') !== false) {
                            $type = 3;
                        }
                        if (stripos($registration->dop_info, 'Продление регистрации') !== false) {
                            $type = 4;
                        }
                        if (stripos($registration->dop_info, 'Погашение долга за просрочку') !== false) {
                            $type = 2;
                        }

                        preg_match_all('!\d+\.*\d*!', $registration->dop_info, $registrationAndKassaId);

                        $registration->type = $type;
                        $registration->id_reg = $registrationAndKassaId[0][0];

                        $newActions[] = $this->generateNewAction($registration);
                    }
                }
                \App\Models\Registration::insert($newRegistrations);
                \App\Models\Action::insert($newActions);
            });

        Schema::table('registrations', function (Blueprint $table) {
            $idStartsWith = \App\Models\Registration::latest('id')->first()->id + 1;
            $table->id()->startingValue($idStartsWith)->change();
        });
    }

    private function generateNewRegistration($registration): array
    {
        return [
            'id' => $registration->id_reg ?? null,
            'shift_id' => $registration->id_smena ?? null,
            'status_id' => $registration->status ?? null,
            'full_name' => $registration->fio ?? null,
            'iin' => $registration->iin ?? null,
            'document_number' => $registration->nom_udas ?? null,
            'document_given_by' => $registration->vydano ?? null,
            'address' => $registration->adres ?? null,
            'phone' => $registration->telefon ?? null,
            'rent_start_date' => $registration->date_st ?? null,
            'rent_end_date' => $registration->date_en ?? null,
            'rent_return_date' => $registration->date_sd ?? null,
            'one_day_rent_amount' => $registration->one_day ?? null,
            'paid' => $registration->opl ?? null,
            'fine' => $registration->shtraf ?? null,
            'duty' => $registration->dolg ?? null,
            'shop_id' => $registration->id_shop ?? null,
            'employee_id' => $registration->user_id_role ?? null,
            'consultant_id' => $registration->consultant_id ?? null,
            'client_type_id' => $registration->client_type_id ?? null,
            'payment_type_id' => $registration->payment_type_id ?? null,
            'for_delete' => $registration->remove ?? null,
            'delivery_type_id' => $registration->delivery_type ?? null,
            'delivery_man_id' => $registration->delivery_man ?? null,
            'delivery_amount' => $registration->delivery ?? null,
            'deleted_at' => $registration->removed ? now() : null
        ];
    }

    private function generateNewAction($registration): array
    {
        return [
            'paid' => $registration->opl ?? null,
            'duty' => $registration->dolg ?? null,
            'action_type_id' => $registration->type ?? null,
            'registration_id' => $registration->id_reg ?? null,
            'act_of_acceptance_of_transfer_document' => $registration->akt_prim ?? null,
            'lease_contract_document' => $registration->dog_aren ?? null
        ];
    }

    public function down(): void
    {
    }
};
