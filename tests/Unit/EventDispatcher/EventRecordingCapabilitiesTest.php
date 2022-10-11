<?php

declare(strict_types=1);

namespace Zorachka\EventDispatcher\Tests\Unit\EventDispatcher;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Zorachka\EventDispatcher\Tests\Datasets\EventDispatcher\Domain\Post;
use Zorachka\EventDispatcher\Tests\Datasets\EventDispatcher\Domain\PostId;
use Zorachka\EventDispatcher\Tests\Datasets\EventDispatcher\Domain\PostWasCreated;

/**
 * @internal
 */
final class EventRecordingCapabilitiesTest extends TestCase
{
    /**
     * @test
     */
    public function shouldReleaseEvents(): void
    {
        $post = Post::create(
            $id = PostId::fromString('00000000-0000-0000-0000-000000000000'),
        );

        Assert::assertEquals([
            PostWasCreated::withId($id),
        ], $post->releaseEvents());
    }
}
