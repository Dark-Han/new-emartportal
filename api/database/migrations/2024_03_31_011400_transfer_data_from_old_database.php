<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        return;
        DB::connection('oldDatabase')
            ->table('regist')
            ->join('kassa', 'regist.id', '=', 'kassa.id_reg')
            ->select('*')
            ->orderBy('regist.id')
            ->chunk(5000, function (\Illuminate\Support\Collection $registrations) {
                $newRegistrations = [];
                $newActions = [];
                $newDocuments = [];
                foreach ($registrations as $registration) {
                    if (empty($registration->dop_info)) {
                        $newRegistrations[] = $this->generateNewRegistration($registration);
                        $newDocuments[] = $this->generateNewDocuments($registration);
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
                \App\Models\TransactionDocument::insert($newDocuments);
            });
    }

    private function generateNewRegistration($registration): array
    {
        return [
            'id' => $registration->id_reg,
            'shift_id' => $registration->id_smena,
            'status_id' => $registration->status,
            'full_name' => $registration->fio,
            'iin' => $registration->iin,
            'document_number' => $registration->nom_udas,
            'document_given_by' => $registration->vydano,
            'address' => $registration->adres,
            'phone' => $registration->telefon,
            'rent_start_date' => $registration->date_st,
            'rent_end_date' => $registration->date_en,
            'rent_return_date' => $registration->date_sd,
            'one_day_rent_amount' => $registration->one_day,
            'fine_amount' => $registration->shtraf,
            'duty_amount' => $registration->duty,
            'shop_id' => $registration->id_shop,
            'employee_id' => $registration->user_id_role,
            'consultant_id' => $registration->consultant_id,
            'client_type_id' => $registration->client_type_id,
            'payment_type_id' => $registration->payment_type_id,
            'for_delete' => $registration->for_delete,
            'delivery_type_id' => $registration->delivery_type,
            'delivery_man_id' => $registration->delivery_man,
            'delivery_amount' => $registration->delivery,

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

    private function generateNewDocuments($registration): array
    {
        return [[
            'document_type_id' => 1,
            'path' => $registration->akt_prim
        ], [
            'document_type_id' => 2,
            'path' => $registration->dog_aren
        ]];
    }

    public function down(): void
    {
    }
};
