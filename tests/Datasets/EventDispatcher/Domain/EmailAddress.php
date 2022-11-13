<?php

declare(strict_types=1);

namespace Zorachka\EventDispatcher\Tests\Datasets\EventDispatcher\Domain;

use Webmozart\Assert\Assert;

final class EmailAddress
{
    private function __construct(
        private string $emailAddress
    ) {
        Assert::email($emailAddress);
    }

    public static function fromString(string $emailAddress): self
    {
        return new self($emailAddress);
    }

    public function asString(): string
    {
        return $this->emailAddress;
    }
}
