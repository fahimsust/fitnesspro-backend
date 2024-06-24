<?php

namespace Tests\Feature\App\Api\Admin\Accounts\Controllers;

use App\Api\Admin\Accounts\Requests\AccountFileRequest;
use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\AccountFile;
use Domain\Sites\Models\Site;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use Illuminate\Support\Facades\Storage;

use function route;

class AccountFileControllerTest extends ControllerTestCase
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
        AccountFile::factory(5)->create(['account_id' => $account->id]);
        $this->getJson(route('admin.account-file.index', ['account_id' => $account->id]))
            ->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'filename',
                ]
            ])
            ->assertJsonCount(5);
    }
    /** @test */
    public function can_create_new_file()
    {
        Storage::fake('s3');
        AccountFileRequest::fake();
        Site::factory()->create(['id' => Config('site.id')]);

        $this->postJson(route('admin.account-file.store'))
            ->assertCreated()
            ->assertJsonStructure(['id']);

        $this->assertDatabaseCount(AccountFile::Table(), 1);
        $accountFile = AccountFile::first();

        // Assert the file was uploaded
        Storage::disk('s3')->assertExists($accountFile->filename);
    }

    /** @test */
    public function can_delete_account_file()
    {
        Storage::fake('s3');
        $accountFile = AccountFile::factory()->create();

        // Optionally upload a file to the fake storage
        Storage::disk('s3')->put($accountFile->filename, 'Dummy content');

        $this->deleteJson(route('admin.account-file.destroy', $accountFile))
            ->assertOk();

        $this->assertDatabaseCount(AccountFile::Table(), 0);
        Storage::disk('s3')->assertMissing($accountFile->filename);
    }
}
