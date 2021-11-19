<?php

declare(strict_types=1);

use Psr\EventDispatcher\ListenerProviderInterface;
use Zorachka\Framework\EventDispatcher\SyncEventDispatcher;
use Zorachka\Framework\Tests\Datasets\EventDispatcher\Application\SendEmailToModerator;
use Zorachka\Framework\Tests\Datasets\EventDispatcher\Domain\PostId;
use Zorachka\Framework\Tests\Datasets\EventDispatcher\Domain\PostWasCreated;

test('SyncEventDispatcher should dispatch', function () {
    $event = PostWasCreated::withId(
        PostId::fromString('00000000-0000-0000-0000-000000000000')
    );

    $listeners = [
        $listener = new SendEmailToModerator(),
    ];
    $registry = $this->createMock(ListenerProviderInterface::class);
    $registry->expects($this->atLeastOnce())
        ->method('getListenersForEvent')
        ->with($event)
        ->willReturn($listeners);

    $dispatcher = new SyncEventDispatcher($registry);

    expect($dispatcher->dispatch($event))->toBe($event);
    expect($listener->isWasCalled())->toBeTrue();
});
