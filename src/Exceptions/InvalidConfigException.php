<?php

declare(strict_types=1);

namespace NotificationChannels\ClickSend\Exceptions;

class InvalidConfigException extends \Exception
{
    public static function missingConfig(): self
    {
        return new self('Missing config. You must set the username password and API endpoint');
    }
}