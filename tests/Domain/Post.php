<?php

declare(strict_types=1);

namespace Zorachka\EventDispatcher\Tests\Domain;

use Zorachka\EventDispatcher\Domain\EventRecordingCapabilities;

final class Post
{
    use EventRecordingCapabilities;

    private PostId $id;

    private function __construct()
    {
    }

    public static function create(PostId $id): self
    {
        $self = new self();
        $self->id = $id;

        $self->registerThat(PostWasCreated::withId($id));

        return $self;
    }
}
