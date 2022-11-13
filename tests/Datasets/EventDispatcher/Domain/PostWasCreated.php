<?php

declare(strict_types=1);

namespace Zorachka\EventDispatcher\Tests\Datasets\EventDispatcher\Domain;

final class PostWasCreated
{
    private function __construct(
        private PostId $id
    ) {
    }

    public static function withId(PostId $id): self
    {
        return new self($id);
    }

    public function id(): PostId
    {
        return $this->id;
    }
}
