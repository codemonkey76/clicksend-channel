<?php

namespace NotificationChannels\ClickSend;

use Illuminate\Support\Arr;

class ClickSendMessage
{
    public string $content;
    public ?string $sender = null;
    public ?string $reference = null;
    public ?int $delay = null;

    public function __construct(string $content = '')
    {
        $this->content = $content;
    }

    public function content(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function sender(string $sender): self
    {
        $this->sender = $sender;

        return $this;
    }

    public function delay(int $delayMinutes): self
    {
        $this->delay = $delayMinutes;

        return $this;
    }

    public function reference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }
}
