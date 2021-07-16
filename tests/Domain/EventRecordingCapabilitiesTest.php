<?php

declare(strict_types=1);

namespace Zorachka\EventDispatcher\Tests\Domain;

use PHPUnit\Framework\TestCase;

final class EventRecordingCapabilitiesTest extends TestCase
{
    public function testReleaseEvents(): void
    {
        $post = Post::create(
            $id = PostId::fromString('00000000-0000-0000-0000-000000000000'),
        );

        self::assertEquals([
            PostWasCreated::withId($id),
        ], $post->releaseEvents());
    }
}
