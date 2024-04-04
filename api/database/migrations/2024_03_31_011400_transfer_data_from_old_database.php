<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        DB::connection('oldDatabase')
            ->table('regist')
            ->join('kassa', 'regist.id', '=', 'kassa.id_reg')
            ->select('*')
            ->orderBy('regist.id')
            ->chunk(5000, function (\Illuminate\Support\Collection $registrations) {
                $newRegistrations = [];
                $newActions = [];
                foreach ($registrations as $registration) {
                    if (empty($registration->dop_info)) {
                        $newRegistrations[] = $this->generateNewRegistration($registration);
                        $registration->type = 'opening';
                        $newActions[] = $this->generateNewAction($registration);
                    } else {
                        $type = '';
                        if (stripos($registration->dop_info, 'Закрытие регистрации') !== false) {
                            $type = 'closing';
                        }
                        if (stripos($registration->dop_info, 'Продление регистрации') !== false) {
                            $type = 'extension';
                        }
                        if (stripos($registration->dop_info, 'Погашение долга за просрочку') !== false) {
                            $type = 'repayment';
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
    }

    private function generateNewRegistration($registration): array
    {
        return [
            'id' => $registration->id_reg,
            'id_smena' => $registration->id_smena,
            'cher_spis' => $registration->cher_spis,
            'fio' => $registration->fio,
            'iin' => $registration->iin,
            'nom_udas' => $registration->nom_udas,
            'vydano' => $registration->vydano,
            'address' => $registration->adres,
            'phone' => $registration->telefon,
            'extra_information' => $registration->dop_info,
            'akt_prim' => $registration->akt_prim,
            'dog_aren' => $registration->dog_aren,
            'delivery_type' => $registration->delivery_type,
            'date_st' => $registration->date_st,
            'date_en' => $registration->date_en,
            'date_sd' => $registration->date_sd,
            'delivery_man' => $registration->delivery_man,
            'id_shop' => $registration->id_shop,
            'user_id_role' => $registration->user_id_role,
            'payment_type_id' => $registration->payment_type_id,
            'consultant_id' => $registration->consultant_id,
            'one_day_payment' => $registration->one_day,
            'shtraf' => $registration->shtraf,
            'delivery_payment' => $registration->delivery,
            'status' => $registration->status,
        ];
    }

    private function generateNewAction($registration): array
    {
        return [
            'paid' => $registration->opl,
            'duty' => $registration->dolg,
            'type' => $registration->type,
            'registration_id' => $registration->id_reg
        ];
    }

    public function down(): void
    {
    }
};
