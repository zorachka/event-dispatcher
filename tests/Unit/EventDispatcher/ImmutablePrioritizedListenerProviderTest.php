<?php

declare(strict_types=1);


use Zorachka\Framework\EventDispatcher\Exceptions\CouldNotFindListener;
use Zorachka\Framework\EventDispatcher\ImmutablePrioritizedListenerProvider;
use Zorachka\Framework\EventDispatcher\ListenerPriority;
use Zorachka\Framework\EventDispatcher\PrioritizedListenerProvider;
use Zorachka\Framework\Tests\Datasets\EventDispatcher\Application\SendEmailToModerator;
use Zorachka\Framework\Tests\Datasets\EventDispatcher\Application\SendWelcomeEmail;
use Zorachka\Framework\Tests\Datasets\EventDispatcher\Domain\EmailAddress;
use Zorachka\Framework\Tests\Datasets\EventDispatcher\Domain\EventWithoutListener;
use Zorachka\Framework\Tests\Datasets\EventDispatcher\Domain\PostId;
use Zorachka\Framework\Tests\Datasets\EventDispatcher\Domain\PostWasCreated;
use Zorachka\Framework\Tests\Datasets\EventDispatcher\Domain\UserWasRegistered;

beforeEach(function () {
    $providers = [];
    $listenersDataset = [
        PostWasCreated::class => [
            PostWasCreated::withId(
                PostId::fromString('00000000-0000-0000-0000-000000000000'),
            ),
            [
                new SendEmailToModerator(ListenerPriority::HIGH),
                new SendEmailToModerator(ListenerPriority::NORMAL),
                new SendEmailToModerator(ListenerPriority::LOW),
            ]
        ],
        UserWasRegistered::class => [
            UserWasRegistered::withEmailAddress(
                EmailAddress::fromString('email@tld.com'),
            ),
            [
                new SendWelcomeEmail(ListenerPriority::HIGH),
                new SendWelcomeEmail(ListenerPriority::NORMAL),
                new SendWelcomeEmail(ListenerPriority::LOW),
            ]
        ],
    ];

    foreach ($listenersDataset as $eventClassName => [$event, $listeners]) {
        $provider = $this->createMock(PrioritizedListenerProvider::class);
        $provider
            ->method('eventClassName')
            ->willReturn($eventClassName);
        $provider
            ->method('getListenersForEvent')
            ->with($event)
            ->willReturn($listeners);

        $providers[] = $provider;
    }

    $this->registry = new ImmutablePrioritizedListenerProvider($providers);
});

test('ImmutablePrioritizedListenerProvider throws exception if could not find listener', function () {
    $event = new EventWithoutListener();
    $this->registry->getListenersForEvent($event);
})->throws(CouldNotFindListener::class);

test('ImmutablePrioritizedListenerProvider should get listeners for event with priority', function (
    object $event,
    array $expectedListeners,
) {
    expect($this->registry->getListenersForEvent($event))
        ->toMatchArray($expectedListeners);
})->with([
    PostWasCreated::class => [
        PostWasCreated::withId(
            PostId::fromString('00000000-0000-0000-0000-000000000000'),
        ),
        [
            new SendEmailToModerator(ListenerPriority::HIGH),
            new SendEmailToModerator(ListenerPriority::NORMAL),
            new SendEmailToModerator(ListenerPriority::LOW),
        ]
    ],
    UserWasRegistered::class => [
        UserWasRegistered::withEmailAddress(
            EmailAddress::fromString('email@tld.com'),
        ),
        [
            new SendWelcomeEmail(ListenerPriority::HIGH),
            new SendWelcomeEmail(ListenerPriority::NORMAL),
            new SendWelcomeEmail(ListenerPriority::LOW),
        ]
    ],
]);
