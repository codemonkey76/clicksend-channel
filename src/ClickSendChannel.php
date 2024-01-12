<?php

namespace NotificationChannels\ClickSend;

use Exception;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Notifications\Notification;
use Codemonkey76\ClickSend\ClickSendResponse;
use Illuminate\Notifications\Events\NotificationFailed;
use NotificationChannels\ClickSend\Exceptions\CouldNotSendNotification;

class ClickSendChannel
{
    public function __construct(protected ClickSend $clickSend, protected Dispatcher $events) {}

    /**
     * @throws CouldNotSendNotification
     */
    public function send(mixed $notifiable, Notification $notification): ?ClickSendResponse
    {
        try {
            $to = $this->getTo($notifiable, $notification);
            $message = $notification->toClickSend($notifiable);

            if (is_string($message)) {
                $message = new ClickSendMessage($message);
            }

            if (! $message instanceof ClickSendMessage) {
                throw CouldNotSendNotification::invalidMessageObject($message);
            }

            return $this->clickSend->sendMessage($message, $to);

        } catch (Exception $exception) {
            $event = new NotificationFailed(
                $notifiable,
                $notification,
                'clicksend',
                [
                    'message' => $exception->getMessage(),
                    'exception' => $exception
                ]
            );
            $this->events->dispatch($event);

            if ($this->clickSend->config->isIgnoredErrorCode($exception->getCode())) {
                return null;
            }

            throw $exception;
        }
    }

    /**
     * @throws CouldNotSendNotification
     */
    protected function getTo($notifiable, $notification = null)
    {
        if ($notifiable->routeNotificationFor(self::class, $notification)) {
            return $notifiable->routeNotificationFor(self::class, $notification);
        }

        if ($notifiable->routeNotificationFor('clicksend', $notification)) {
            return $notifiable->routeNotificationFor('clicksend', $notification);
        }

        if (isset($notifiable->phone_number)) {
            return $notifiable->phone_number;
        }

        throw CouldNotSendNotification::invalidReceiver();
    }
}
