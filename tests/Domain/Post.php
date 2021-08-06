<?php

declare(strict_types=1);

namespace Zorachka\EventDispatcher\Tests\Domain;

use Zorachka\EventDispatcher\Domain\EventRecordingCapabilities;

final class Post
{
    use EventRecordingCapabilities;

    private function __construct(
        private PostId $id
    ) {
    }

    public static function create(PostId $id): self
    {
        $self = new self($id);
        $self->registerThat(PostWasCreated::withId($id));

        return $self;
    }
}
