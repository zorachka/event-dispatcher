<?php

declare(strict_types=1);

namespace Zorachka\EventDispatcher\Tests\Domain;

final class PostWasCreated
{
    private PostId $id;

    private function __construct()
    {
    }

    public static function withId(PostId $id): self
    {
        $self = new self();
        $self->id = $id;

        return $self;
    }

    /**
     * @return PostId
     */
    public function id(): PostId
    {
        return $this->id;
    }
}
