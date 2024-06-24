<?php

namespace Support\Contracts\Mail;

use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\Membership\Subscription;
use Domain\Messaging\Models\MessageTemplate;
use Domain\Orders\Models\Order\Order;
use Domain\Orders\Models\Order\Shipments\Shipment;
use Domain\Orders\Traits\HasOrder;
use Domain\Orders\Traits\HasPackage;
use Domain\Orders\Traits\HasShipment;
use Domain\Sites\Models\Site;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Support\Helpers\HandleMessageKeys;
use Support\Mail\AbstractMailable;
use Throwable;

abstract class AbstractSendUsingMessageTemplateSystemId
extends AbstractMailable
{
    use Queueable,
        SerializesModels,
        HasOrder,
        HasShipment,
        HasPackage;

    public MessageTemplate $template;
    public HandleMessageKeys $keyHandler;

    public function __construct(
        public Account $account,
        public ?Site   $site = null
    ) {
        $this->keyHandler = new HandleMessageKeys;

        if ($site)
            $this->setSite($site);
    }

    public function exception(Throwable $throwable): static
    {
        $this->keyHandler->setException($throwable);

        return $this;
    }

    public function order(Order $order): static
    {
        $this->keyHandler->order($order);

        return $this;
    }

    public function shipment(Shipment $shipment): static
    {
        $this->keyHandler->shipment($shipment);

        return $this;
    }

    public function membership(Subscription $membership): static
    {
        $this->keyHandler->membership($membership);

        return $this;
    }

    abstract public function messageTemplateSystemId(): string;

    public function prep()
    {
        parent::prep();

        $this->keyHandler
            ->setSite($this->site)
            ->setAccount($this->account);

        $this->template = MessageTemplate::FindBySystemId(
            $this->messageTemplateSystemId()
        )
            ->replaceKeysUsingHandler($this->keyHandler);

        $this->siteMailer()
            ->plainText($this->template->plain_text)
            ->html($this->template->html);

        return $this;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->prep();

        return $this->from($this->site->email, $this->site->name)
            ->to($this->account->email, $this->account->first_name)
            ->subject($this->template->subject)
            ->plainText($this->siteMailer->plain_text)
            ->html($this->siteMailer->html);
    }
}
