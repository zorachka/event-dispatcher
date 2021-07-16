<?php

declare(strict_types=1);

namespace Zorachka\EventDispatcher\Tests\Infrastructure;

use PHPUnit\Framework\TestCase;
use Zorachka\EventDispatcher\Infrastructure\ImmutablePrioritizedListenerProvider;
use Zorachka\EventDispatcher\Infrastructure\ListenerPriority;
use Zorachka\EventDispatcher\Infrastructure\PrioritizedListenerProvider;
use Zorachka\EventDispatcher\Tests\Application\SendEmailToModerator;
use Zorachka\EventDispatcher\Tests\Application\SendWelcomeEmail;
use Zorachka\EventDispatcher\Tests\Domain\EmailAddress;
use Zorachka\EventDispatcher\Tests\Domain\PostId;
use Zorachka\EventDispatcher\Tests\Domain\PostWasCreated;
use Zorachka\EventDispatcher\Tests\Domain\UserWasRegistered;

final class ImmutablePrioritizedListenerProviderTest extends TestCase
{
    private ImmutablePrioritizedListenerProvider $registry;

    protected function setUp(): void
    {
        parent::setUp();

        $providers = [];

        foreach ($this->listenersProvider() as $eventClassName => [$event, $listeners]) {
            $provider = self::createMock(PrioritizedListenerProvider::class);
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
    }

    public function listenersProvider(): array
    {
        return [
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
    }

    /**
     * @dataProvider listenersProvider
     */
    public function testGetListenersForEventWithPriority(object $event, array $expectedListeners): void
    {
        $this->assertEqualsCanonicalizing($expectedListeners, $this->registry->getListenersForEvent($event));
    }
}
