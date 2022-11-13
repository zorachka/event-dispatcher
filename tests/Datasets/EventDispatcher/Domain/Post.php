<?php

declare(strict_types=1);

namespace Zorachka\EventDispatcher\Tests\Datasets\EventDispatcher\Domain;

use Zorachka\EventDispatcher\EventRecordingCapabilities;

final class Post
{
    use EventRecordingCapabilities;

    private function __construct(
        /** @phpstan-ignore-next-line */
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
