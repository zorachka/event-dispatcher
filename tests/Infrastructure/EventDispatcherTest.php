<?php

declare(strict_types=1);

namespace Zorachka\EventDispatcher\Tests\Infrastructure;

use PHPUnit\Framework\TestCase;
use Zorachka\EventDispatcher\Infrastructure\EventDispatcher;
use Zorachka\EventDispatcher\Infrastructure\ListenerRegistry;
use Zorachka\EventDispatcher\Tests\PostId;
use Zorachka\EventDispatcher\Tests\PostWasCreated;

final class EventDispatcherTest extends TestCase
{
    public function testDispatch(): void
    {
        $registry = self::createMock(ListenerRegistry::class);

        $dispatcher = new EventDispatcher($registry);

        $event = PostWasCreated::withId(
            PostId::fromString('00000000-0000-0000-0000-000000000000')
        );
        self::assertEquals($event, $dispatcher->dispatch($event));
    }
}
