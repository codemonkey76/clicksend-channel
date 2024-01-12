<?php

namespace NotificationChannels\ClickSend\Exceptions;

use NotificationChannels\ClickSend\ClickSendMessage;

class CouldNotSendNotification extends \Exception
{
    public static function invalidReceiver(): self
    {
        return new static(
            'The notifiable did not have a receiving phone number.
            Add a routeNotificationForClickSend method or a phone_number
            attribute to your notifiable.'
        );
    }

    public static function invalidMessageObject($message): self
    {
        $className = is_object($message) ? get_class($message) : 'Unknown';

        return new static(
            "Notification was not sent. Message object class
             `{$className}` is invalid. It should be ".ClickSendMessage::class
        );
    }
}
