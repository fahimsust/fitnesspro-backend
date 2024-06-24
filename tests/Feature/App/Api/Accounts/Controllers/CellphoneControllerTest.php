<?php

namespace Tests\Feature\App\Api\Accounts\Controllers;

use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use function route;
use Tests\TestCase;

class CellphoneControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->apiTestToken();
        $this->seedAccountCellphoneField();
    }

    /** @test */
    public function can_update_accounts_cellphone()
    {
        $currentCell = $this->account->cellphone;
        $newCell = '+2342222222222';

        $this->assertNotEquals($currentCell, $newCell); //confirm current != new

        $response = $this->postJson(route('mobile.account.cellphone.store', $this->account), [
            'new_cellphone' => $newCell,
        ])->assertStatus(Response::HTTP_CREATED);

        $this->assertEquals($newCell, $response['cellphone']);
        $this->assertEquals($newCell, $this->account->fresh()->cellphone); //this isn't necessary needed, but double check database doesn't hurt
    }

    /** @test */
    public function can_update_if_field_doesnt_already_exist()
    {
        $this->account->cellphoneField()->delete();

        $currentCell = $this->account->cellphone;
        $newCell = '+2342222222222';

        $this->assertNotEquals($currentCell, $newCell); //confirm current != new

        $response = $this->postJson(route('mobile.account.cellphone.store', $this->account), [
            'new_cellphone' => $newCell,
        ])->assertStatus(Response::HTTP_CREATED);

        $this->assertEquals($newCell, $response['cellphone']);
        $this->assertEquals($newCell, $this->account->fresh()->cellphone);
    }

    /** @test */
    public function invalid_phone_fails_to_update()
    {
        $this->withoutExceptionHandling();
        $this->expectException(ValidationException::class);

        $invalidCell = 'a2342222222222';

        $this->postJson(route('mobile.account.cellphone.store', $this->account), [
            'new_cellphone' => $invalidCell,
        ]);
    }
}
