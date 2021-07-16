<?php

declare(strict_types=1);

namespace Zorachka\EventDispatcher\Tests\Infrastructure;

use PHPUnit\Framework\TestCase;
use Psr\EventDispatcher\ListenerProviderInterface;
use Zorachka\EventDispatcher\Infrastructure\SyncEventDispatcher;
use Zorachka\EventDispatcher\Tests\PostId;
use Zorachka\EventDispatcher\Tests\PostWasCreated;
use Zorachka\EventDispatcher\Tests\SendEmailToModerator;

final class SyncEventDispatcherTest extends TestCase
{
    public function testDispatch(): void
    {
        $event = PostWasCreated::withId(
            PostId::fromString('00000000-0000-0000-0000-000000000000')
        );

        $listeners = [
            $listener = new SendEmailToModerator(),
        ];
        $registry = self::createMock(ListenerProviderInterface::class);
        $registry->expects($this->atLeastOnce())
            ->method('getListenersForEvent')
            ->with($event)
            ->willReturn($listeners);

        $dispatcher = new SyncEventDispatcher($registry);

        self::assertEquals($event, $dispatcher->dispatch($event));
        self::assertTrue($listener->isWasCalled());
    }
}
