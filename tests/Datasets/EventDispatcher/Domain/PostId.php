<?php

declare(strict_types=1);

namespace Zorachka\EventDispatcher\Tests\Datasets\EventDispatcher\Domain;

use Webmozart\Assert\Assert;

final class PostId
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
