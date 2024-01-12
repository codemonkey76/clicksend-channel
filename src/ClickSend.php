<?php

namespace NotificationChannels\ClickSend;

use Codemonkey76\ClickSend\SmsMessage;
use Codemonkey76\ClickSend\ClickSendResponse;
use Codemonkey76\ClickSend\ClickSend as ClickSendService;
use NotificationChannels\ClickSend\Exceptions\InvalidConfigException;

class ClickSend
{
    protected ClickSendService $clickSend;

    /**
     * @throws InvalidConfigException
     */
    public function __construct(public ClickSendConfig $config) {
        if (! $config->configurationValid()) {
            throw InvalidConfigException::missingConfig();
        }
        $this->clickSend = new ClickSendService(
            $config->getUsername(),
            $config->getPassword(),
            $config->getApiEndpoint()
        );
    }

    public function sendMessage(ClickSendMessage $message, ?string $to): ClickSendResponse
    {
        $m = new SmsMessage($to, $message->sender, $message->content);
        return $this->clickSend->sendMessage($m);
    }
}