<?php

declare(strict_types=1);

namespace Zorachka\EventDispatcher\Tests;

use Webmozart\Assert\Assert;

final class UserId
{
    private string $id;

    private function __construct()
    {
    }

    public static function fromString(string $id): self
    {
        Assert::uuid($id);
        $self = new self();
        $self->id = $id;

        return $self;
    }

    public function asString(): string
    {
        return $this->id;
    }
}
