<?php

namespace NotificationChannels\ClickSend;

class ClickSendConfig
{
    private array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function getUsername(): ?string
    {
        return $this->config['username'] ?? null;
    }

    public function getPassword(): ?string
    {
        return $this->config['password'] ?? null;
    }

    public function getApiEndpoint(): ?string
    {
        return $this->config['api_endpoint'] ?? null;
    }

    public function configurationValid(): bool
    {
        return !(
            is_null($this->getUsername()) ||
            is_null($this->getPassword()) ||
            is_null($this->getApiEndpoint())
        );
    }

    public function getIgnoredErrorCodes(): array
    {
        return $this->config['ignored_error_codes'] ?? [];
    }

    public function isIgnoredErrorCode(int $code): bool
    {
        if (in_array('*', $this->getIgnoredErrorCodes(), true)) {
            return true;
        }

        return in_array($code, $this->getIgnoredErrorCodes(), true);
    }
}