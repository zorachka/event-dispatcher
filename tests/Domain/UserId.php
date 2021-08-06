<?php

declare(strict_types=1);

namespace Zorachka\EventDispatcher\Tests\Domain;

use Webmozart\Assert\Assert;

final class UserId
{
    private function __construct(
        private string $id
    ) {
        Assert::uuid($id);
    }

    public static function fromString(string $id): self
    {
        return new self($id);
    }

    public function asString(): string
    {
        return $this->id;
    }
}
