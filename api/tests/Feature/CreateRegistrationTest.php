<?php

namespace Tests\Feature;

use App\Models\Tool;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateRegistrationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @todo вынести константы в енум
     */
    const IN_RENT = 2;

    private User $employee;

    public function setUp(): void
    {
        parent::setUp();

        $this->employee = User::factory()->create();
    }

    public function testCreate(): void
    {
        $registrationsRentTools = collect([
            Tool::factory()->forToolType(['rental_price' => 1000])->create(),
            Tool::factory()->forToolType(['rental_price' => 2000])->create(),
            Tool::factory()->forToolType(['rental_price' => 3000])->create(),
        ]);

        $oneDayRentAmount = 6000;

        $rentToolsIds = $registrationsRentTools->pluck('id')->toArray();

        $request = [
            'full_name' => 'test full name',
            'iin' => '111111111',
            'document_number' => '222222',
            'document_given_by' => 'kz',
            'address' => 'test address',
            'phone' => '333333',
            'rent_start_date' => '2024-06-01 15:14',
            'rent_end_date' => '2024-06-03 15:14',
            'paid' => 12000,
            'client_type_id' => 1,
            'payment_type_id' => 1,
            'rent_tools_ids' => $rentToolsIds,
        ];

        $response = $this->actingAs($this->employee)->post('/api/v1/registrations', $request);
        $response->assertOk();

        $this->assertRegistrationWasCreated($request, $oneDayRentAmount);
        $this->assertActionWasCreated($request);
        $this->assertToolsWasTakenFromWarehouse($rentToolsIds);
    }

    private function assertRegistrationWasCreated(array $request, int $oneDayRentAmount): void
    {
        $this->assertDatabaseHas('registrations', [
            'full_name' => $request['full_name'],
            'iin' => $request['iin'],
            'document_number' => $request['document_number'],
            'document_given_by' => $request['document_given_by'],
            'address' => $request['address'],
            'phone' => $request['phone'],
            'rent_start_date' => $request['rent_start_date'],
            'rent_end_date' => $request['rent_end_date'],
            'paid' => $request['paid'],
            'client_type_id' => $request['client_type_id'],
            'payment_type_id' => $request['payment_type_id'],
            'one_day_rent_amount' => $oneDayRentAmount,
            'employee_id' => $this->employee->id,
            'shop_id' => $this->employee->shop_id,
            'status_id' => 1,
        ]);
    }

    private function assertActionWasCreated(array $request): void
    {
        $this->assertDatabaseHas('actions', [
            'registration_id' => 1,
            'action_type_id' => 1,
            'paid' => $request['paid'],
            'duty' => isset($request['duty']) ?? 0,
            'employee_id' => $this->employee->id,
            'shop_id' => $this->employee->shop_id
        ]);
    }

    private function assertToolsWasTakenFromWarehouse(array $toolsIds): void
    {
        foreach ($toolsIds as $id) {
            $this->assertDatabaseHas('tools', [
                'id' => $id,
                'status_id' => self::IN_RENT
            ]);
        }
    }
}
