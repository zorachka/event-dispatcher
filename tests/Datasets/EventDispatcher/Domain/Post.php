<?php

declare(strict_types=1);

namespace Zorachka\Framework\Tests\Datasets\EventDispatcher\Domain;

use Zorachka\Framework\EventDispatcher\EventRecordingCapabilities;

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
