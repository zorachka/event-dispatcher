<?php

declare(strict_types=1);

namespace Zorachka\EventDispatcher\Tests\Domain;

final class UserWasRegistered
{
    private EmailAddress $emailAddress;

    private function __construct()
    {
    }

    public static function withEmailAddress(EmailAddress $emailAddress): self
    {
        $self = new self();
        $self->emailAddress = $emailAddress;

        return $self;
    }

    /**
     * @return EmailAddress
     */
    public function emailAddress(): EmailAddress
    {
        return $this->emailAddress;
    }
}
