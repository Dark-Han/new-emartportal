<?php

namespace App\Service;

use App\Models\Action;
use App\Models\Registration;
use App\Models\Tool;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class RegistrationService
{
    /**
     * @todo создать enum для констант
     */
    const REGISTRATION_CREATED = 1;
    const TOOL_IN_RENT = 2;
    const REGISTRATION_IN_RENT = 1;

    public function create(array $data): Registration
    {
        $registration = \DB::transaction(function () use ($data) {
            /**
             * @todo в будущем проверять существуют ли выбранные
             * инструменты на складе
             */

            $data['one_day_rent_amount'] = $this->calculateOneDayRentAmountForTools($data['rent_tools_ids']);
            $rentAmount = $this->calculateRentAmountForPeriod(
                $data['one_day_rent_amount'],
                $data['rent_start_date'],
                $data['rent_end_date']
            );

            if (($data['duty'] + $data['paid']) > $rentAmount) {
                throw new \RuntimeException('Оплачено больше чем нужно!');
            }

            if (($data['duty'] + $data['paid']) < $rentAmount) {
                throw new \RuntimeException('Введите долг или оплатите полную сумму!');
            }

            $registration = $this->createRegistration($data);
            $this->createActionForRegistration($registration->id, $data);
            $this->giveToolsFromWarehouseToRent($data['rent_tools_ids']);

            return $registration;
        });

        $registration->load(['actions', 'status', 'shop', 'createdEmployee']);
        return $registration;
    }

    private function calculateOneDayRentAmountForTools(array $rentToolsIds): int
    {
        $oneDayRent = 0;
        $rentTools = Tool::with(['toolType'])->whereIn('id', $rentToolsIds)->get();

        foreach ($rentTools as $tool) {
            $oneDayRent += $tool->toolType->rental_price;
        }
        return $oneDayRent;
    }

    private function calculateRentAmountForPeriod(
        int    $oneDayRentAmount,
        string $rentStartDate,
        string $rentEndDate
    ): int
    {
        $days = Carbon::createFromTimeString($rentEndDate)->diff(Carbon::createFromTimeString($rentStartDate))->days;
        return $oneDayRentAmount * $days;
    }

    private function createRegistration(array $data): Registration
    {
        return Registration::create([
            'status_id' => self::REGISTRATION_IN_RENT,
            'full_name' => $data['full_name'],
            'iin' => $data['iin'],
            'document_number' => $data['document_number'],
            'document_given_by' => $data['document_given_by'],
            'address' => $data['address'],
            'phone' => $data['phone'],
            'rent_start_date' => $data['rent_start_date'],
            'rent_end_date' => $data['rent_end_date'],
            'paid' => $data['paid'],
            'client_type_id' => $data['client_type_id'],
            'payment_type_id' => $data['payment_type_id'],
            'one_day_rent_amount' => $data['one_day_rent_amount'],
            'shop_id' => Auth::user()->shop_id,
            'employee_id' => Auth::user()->id
        ]);
    }

    private function createActionForRegistration(int $registrationId, array $data): Action
    {
        return Action::create([
            'registration_id' => $registrationId,
            'action_type_id' => self::REGISTRATION_CREATED,
            'paid' => $data['paid'],
            'duty' => $data['duty'] ?? 0,
            'act_of_acceptance_of_transfer_document' => '',
            'lease_contract_document' => '',
            'shop_id' => Auth::user()->shop_id,
            'employee_id' => Auth::user()->id
        ]);
    }

    private function giveToolsFromWarehouseToRent(array $rent_tools_ids): void
    {
        Tool::whereIn('id', $rent_tools_ids)->update(['status_id' => self::TOOL_IN_RENT]);
    }
}
