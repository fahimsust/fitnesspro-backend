<?php

namespace Support\Helpers;

use Domain\Accounts\Actions\BuildAccountMessageKeysValuesFromModel;
use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\Membership\Subscription;
use Domain\Affiliates\Actions\BuildAffiliateMessageKeysValuesFromModel;
use Domain\Affiliates\Models\Affiliate;
use Domain\Orders\Actions\Order\Messages\BuildOrderMessageKeysValuesFromModel;
use Domain\Orders\Models\Order\Order;
use Domain\Orders\Traits\HasOrder;
use Domain\Orders\Traits\HasPackage;
use Domain\Orders\Traits\HasShipment;
use Domain\Sites\Actions\BuildSiteMessageKeysValuesFromModel;
use Domain\Sites\Models\Site;
use Illuminate\Support\Collection;
use Illuminate\Support\Traits\Conditionable;
use Illuminate\Validation\ValidatesWhenResolvedTrait;
use Throwable;

class HandleMessageKeys
{
    use HasOrder,
        HasShipment,
        HasPackage,
        Conditionable;

    public $keys = [];

    private ?Throwable $exception = null;

    public ?Account $account = null;

    public ?Affiliate $affiliate = null;
    public ?Subscription $membership = null;

    public Site $site;

    public function __construct($additionalKeys = [])
    {
        if (count($additionalKeys)) {
            $this->keys = array_merge($additionalKeys, $this->keys);
        }
    }

    public function setException(Throwable $throwable): static
    {
        $this->exception = $throwable;
        $this->keys += [
            'EXCEPTION_MESSAGE' => $throwable->getMessage(),
            'EXCEPTION_CODE' => $throwable->getCode()
        ];

        return $this;
    }

    public function membership(Subscription $membership)
    {
        $this->membership = $membership;

        $this->keys += [
            'MEMBERSHIP_START_DATE' => $membership->start_date->format("M jS, Y"),
            'MEMBERSHIP_END_DATE' => $membership->end_date->format("M jS, Y"),
            'MEMBERSHIP_CANCELLED_DATE' => $membership->cancelled?->format("M jS, Y"),
            'MEMBERSHIP_LEVEL' => $membership->level->name,
            'MEMBERSHIP_PRICE' => $membership->subscription_price,
            'MEMBERSHIP_PAID' => $membership->amount_paid,
        ];

        return $this;
    }

    public function setOrder(Order $order): static
    {
        $this->order($order);

        $this->mergeKeys(
            BuildOrderMessageKeysValuesFromModel::now($this->order)
        );

        return $this;
    }

    public function setSite(Site $site): static
    {
        $this->site = $site;

        $this->mergeKeys(
            BuildSiteMessageKeysValuesFromModel::now($this->site)
        );

        return $this;
    }

    public function setAccount(Account $account): static
    {
        $this->account = $account;

        $this->mergeKeys(
            BuildAccountMessageKeysValuesFromModel::now($this->account)
        );

        return $this;
    }
    public function setAffiliate(Affiliate $affiliate): static
    {
        $this->affiliate = $affiliate;

        $this->mergeKeys(
            BuildAffiliateMessageKeysValuesFromModel::now($this->affiliate)
        );

        return $this;
    }

    protected function mergeKeys(array $keys): static
    {
        $this->keys = array_merge(
            $this->keys,
            $keys
        );

        return $this;
    }

    public function replaceForAccount(&$content): static
    {
        if (!$this->account) {
            return $this;
        }

        if (preg_match_all('/{ACCOUNT_CUSTOM_FIELD=([a-z0-9_-]+)}/', $content, $matches)) {
            $replaced = [];
            foreach ($matches[1] as $m) {
                if (in_array($m, $replaced))
                    continue;

                $split = explode('_', $m);
                if (is_array($this->account->field_values[$split[0]][$split[1]][$split[2]])) {
                    $el = implode('; ', $this->account->field_values[$split[0]][$split[1]][$split[2]]);
                } else {
                    $el = $this->account->field_values[$split[0]][$split[1]][$split[2]];
                }
                $content = str_replace('{ACCOUNT_CUSTOM_FIELD=' . $m . '}', $el, $content);
                $replaced[] = $m;
            }
        }

        return $this;
    }


    public function replaceAll($content): string
    {
        $this->replaceForAccount($content);

        foreach ($this->keys as $k => $v) {
            $content = str_replace('{' . $k . '}', $v ?? '', $content);
        }

        return $content;
    }

    private function addKeyAndValues($obj, Collection $keys): static
    {
        $keys->each(function ($key) use ($obj) {
            $this->keys[$key->key_id] = $obj->{$key->key_var};
        });

        return $this;
    }
}
