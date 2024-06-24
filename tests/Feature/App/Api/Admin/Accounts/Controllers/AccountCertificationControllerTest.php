<?php

namespace Tests\Feature\App\Api\Admin\Accounts\Controllers;

use App\Api\Admin\Accounts\Requests\AccountCertificationRequest;
use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\Certifications\Certification;
use Illuminate\Support\Facades\Storage;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use Tests\RequestFactories\App\Api\Admin\Accounts\Requests\UpdateCertificationRequestFactory;
use function route;

class AccountCertificationControllerTest extends ControllerTestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_list_account_certification()
    {
        $account = Account::factory()->create();
        Certification::factory(5)->create(['account_id' => $account->id]);
        $this->getJson(route('admin.account-certification.index', ['account_id' => $account->id]))
            ->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'cert_num',
                    'cert_type',
                    'cert_org',
                    'file_name',
                    'approval_status',
                    'cert_exp'
                ]
            ])
            ->assertJsonCount(5);
    }
    /** @test */
    public function can_create_new_certification()
    {
        Storage::fake('s3');
        AccountCertificationRequest::fake();

        $this->postJson(route('admin.account-certification.store'))
            ->assertCreated()
            ->assertJsonStructure(['id']);

        $this->assertDatabaseCount(Certification::Table(), 1);
        $certification = Certification::first();

        // Assert the file was uploaded
        Storage::disk('s3')->assertExists($certification->file_name);
    }
    /** @test */
    public function can_update_certification()
    {
        Storage::fake('s3');

        $account = Account::factory()->create();
        $certification = Certification::factory()->create(['account_id' => $account->id]);

        // Generate data using the request factory
        $updateCertificationFactory = new UpdateCertificationRequestFactory();
        $updateData = $updateCertificationFactory->definition();

        // Perform the update operation
        $response = $this->putJson(route('admin.account-certification.update', [$certification]), $updateData);

        // Assertions
        $response->assertCreated();
        $updatedCertification = Certification::first();

        // Check if the data was updated correctly
        $this->assertEquals($updateData['cert_num'], $updatedCertification->cert_num);
        $this->assertEquals($updateData['cert_type'], $updatedCertification->cert_type);
        $this->assertEquals($updateData['cert_org'], $updatedCertification->cert_org);
        $this->assertEquals($updateData['approval_status'], $updatedCertification->approval_status);

        // Check if the file was uploaded
        Storage::disk('s3')->assertExists($updatedCertification->file_name);
    }
    /** @test */
    public function can_delete_certification()
    {
        Storage::fake('s3');
        $certification = Certification::factory()->create();

        // Optionally upload a file to the fake storage
        Storage::disk('s3')->put($certification->file_name, 'Dummy content');

        $this->deleteJson(route('admin.account-certification.destroy', $certification))
            ->assertOk();

        $this->assertDatabaseCount(Certification::Table(), 0);
        Storage::disk('s3')->assertMissing($certification->file_name);
    }
}
