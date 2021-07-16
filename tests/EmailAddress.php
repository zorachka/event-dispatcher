<?php

declare(strict_types=1);

namespace Zorachka\EventDispatcher\Tests;

use Webmozart\Assert\Assert;

final class EmailAddress
{
    private string $emailAddress;

    private function __construct()
    {
    }

    public function fromString(string $emailAddress): self
    {
        Assert::email($emailAddress);
        $self = new self();
        $self->emailAddress = $emailAddress;

        return $self;
    }

    public function asString(): string
    {
        return $this->emailAddress;
    }
}
