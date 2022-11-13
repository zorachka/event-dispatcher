<?php

declare(strict_types=1);

namespace Zorachka\EventDispatcher\Tests\Datasets\EventDispatcher\Domain;

final class UserWasRegistered
{
    private function __construct(
        private EmailAddress $emailAddress
    ) {
    }

    public static function withEmailAddress(EmailAddress $emailAddress): self
    {
        return new self($emailAddress);
    }

    public function emailAddress(): EmailAddress
    {
        return $this->emailAddress;
    }
}
