<?php

namespace Tests\Feature\Support\Helpers;

use Domain\Accounts\Models\Account;
use Domain\Messaging\Enums\AccountMessageKeys;
use Domain\Messaging\Enums\OrderMessageKeys;
use Domain\Messaging\Enums\SiteMessageKeys;
use Domain\Messaging\Models\MessageTemplate;
use Domain\Orders\Models\Order\Order;
use Domain\Sites\Models\Site;
use Support\Helpers\HandleMessageKeys;
use Tests\TestCase;

class HandleMessageKeysTest extends TestCase
{
    protected $forgotUserTemplate;

    protected HandleMessageKeys $keyHandler;

    private string $forgotUserContent;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();

        $this->forgotUserTemplate = MessageTemplate::FindBySystemId('forgot_username');

        $this->keyHandler = new HandleMessageKeys();

        $this->forgotUserContent = $this->forgotUserTemplate->plain_text;
    }

    private function contentWithAllKeys($keys): string
    {
        $contents = [];
        foreach ($keys as $key) {
            $contents[] = $key->name.': {'.$key->value.'}';
        }

        return implode("<br>\n", $contents);
    }

    private function placeholderPattern(): string
    {
        return '/\{[A-Z-_0-9]+\}/';
    }

    /** @todo */
    public function can_replace_order_keys()
    {
        $order = Order::factory()->create();
        $orderNo = $order->number;

        $this->keyHandler->order($order);

        $content = $this->contentWithAllKeys(OrderMessageKeys::cases());
        $contentWithKeysReplaced = $this->keyHandler->replaceAll($content);
        $pattern = $this->placeholderPattern();

        $this->assertMatchesRegularExpression($pattern, $content);
        $this->assertDoesNotMatchRegularExpression($pattern, $contentWithKeysReplaced);
        $this->assertStringContainsString('ORDER_NO: '.$orderNo, $contentWithKeysReplaced);
//        $this->assertStringNotContainsString($orderNo, $content);
    }

    /** @todo */
    public function can_replace_site_keys()
    {
        $site = Site::first();
        $siteName = $site->name;

        $this->keyHandler->setSite($site);

        $content = $this->contentWithAllKeys(SiteMessageKeys::cases());
        $contentWithKeysReplaced = $this->keyHandler->replaceAll($content);
        $pattern = $this->placeholderPattern();

        $this->assertMatchesRegularExpression($pattern, $content);
        $this->assertDoesNotMatchRegularExpression($pattern, $contentWithKeysReplaced);
        $this->assertStringContainsString('SITE_NAME: '.$siteName, $contentWithKeysReplaced);
    }

    /** @todo */
    public function can_replace_account_keys()
    {
        $firstName = 'Test-First-Name';
        $account = Account::factory()->create(['first_name' => $firstName]);

        $this->keyHandler->setAccount($account);

        $content = $this->contentWithAllKeys(AccountMessageKeys::cases());
        $contentWithKeysReplaced = $this->keyHandler->replaceAll($content);
        $pattern = $this->placeholderPattern();

        $this->assertMatchesRegularExpression($pattern, $content);
        $this->assertDoesNotMatchRegularExpression($pattern, $contentWithKeysReplaced);
        $this->assertStringContainsString('FIRST_NAME: '.$firstName, $contentWithKeysReplaced);
    }
}
