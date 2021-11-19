<?php

declare(strict_types=1);

use Zorachka\Framework\EventDispatcher\Exceptions\CouldNotFindListener;
use Zorachka\Framework\EventDispatcher\ListenerPriority;
use Zorachka\Framework\EventDispatcher\PrioritizedListenerProvider;
use Zorachka\Framework\Tests\Datasets\EventDispatcher\Application\SendEmailToModerator;
use Zorachka\Framework\Tests\Datasets\EventDispatcher\Domain\EventWithoutListener;
use Zorachka\Framework\Tests\Datasets\EventDispatcher\Domain\PostId;
use Zorachka\Framework\Tests\Datasets\EventDispatcher\Domain\PostWasCreated;

beforeEach(function () {
    $this->provider = new PrioritizedListenerProvider(PostWasCreated::class, [
        ListenerPriority::NORMAL => new SendEmailToModerator(ListenerPriority::NORMAL),
        ListenerPriority::HIGH => new SendEmailToModerator(ListenerPriority::HIGH),
        ListenerPriority::LOW => new SendEmailToModerator(ListenerPriority::LOW),
    ]);
});

test('ImmutablePrioritizedListenerProvider throws exception if could not find listener', function () {
    $event = new EventWithoutListener();
    $this->provider->getListenersForEvent($event);
})->throws(CouldNotFindListener::class);

test('PrioritizedListenerProvider should have event class name', function () {
    expect($this->provider->eventClassName())->toBe(PostWasCreated::class);
});

test('PrioritizedListenerProvider should get listeners for event with priority', function () {
    $event = PostWasCreated::withId(
        PostId::fromString('00000000-0000-0000-0000-000000000000')
    );

    expect($this->provider->getListenersForEvent($event))->toMatchArray([
        new SendEmailToModerator(ListenerPriority::HIGH),
        new SendEmailToModerator(ListenerPriority::NORMAL),
        new SendEmailToModerator(ListenerPriority::LOW),
    ]);
});
