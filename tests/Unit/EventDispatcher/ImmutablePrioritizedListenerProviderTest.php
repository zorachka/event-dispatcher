<?php

declare(strict_types=1);

namespace Zorachka\EventDispatcher\Tests\Unit\EventDispatcher;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Psr\EventDispatcher\ListenerProviderInterface;
use Zorachka\EventDispatcher\Exceptions\CouldNotFindListener;
use Zorachka\EventDispatcher\ImmutablePrioritizedListenerProvider;
use Zorachka\EventDispatcher\ListenerPriority;
use Zorachka\EventDispatcher\PrioritizedListenerProvider;
use Zorachka\EventDispatcher\Tests\Datasets\EventDispatcher\Application\SendEmailToModerator;
use Zorachka\EventDispatcher\Tests\Datasets\EventDispatcher\Application\SendWelcomeEmail;
use Zorachka\EventDispatcher\Tests\Datasets\EventDispatcher\Domain\EmailAddress;
use Zorachka\EventDispatcher\Tests\Datasets\EventDispatcher\Domain\EventWithoutListener;
use Zorachka\EventDispatcher\Tests\Datasets\EventDispatcher\Domain\PostId;
use Zorachka\EventDispatcher\Tests\Datasets\EventDispatcher\Domain\PostWasCreated;
use Zorachka\EventDispatcher\Tests\Datasets\EventDispatcher\Domain\UserWasRegistered;

/**
 * @internal
 */
final class ImmutablePrioritizedListenerProviderTest extends TestCase
{
    private ListenerProviderInterface $registry;

    protected function setUp(): void
    {
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
                ],
            ],
            UserWasRegistered::class => [
                UserWasRegistered::withEmailAddress(
                    EmailAddress::fromString('email@tld.com'),
                ),
                [
                    new SendWelcomeEmail(ListenerPriority::HIGH),
                    new SendWelcomeEmail(ListenerPriority::NORMAL),
                    new SendWelcomeEmail(ListenerPriority::LOW),
                ],
            ],
        ];

        foreach ($listenersDataset as $eventClassName => [$event, $listeners]) {
            /** @phpstan-ignore-next-line */
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
    }

    public function dataListenersForEvent(): array
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
                ],
            ],
            UserWasRegistered::class => [
                UserWasRegistered::withEmailAddress(
                    EmailAddress::fromString('email@tld.com'),
                ),
                [
                    new SendWelcomeEmail(ListenerPriority::HIGH),
                    new SendWelcomeEmail(ListenerPriority::NORMAL),
                    new SendWelcomeEmail(ListenerPriority::LOW),
                ],
            ],
        ];
    }

    /**
     * @test
     */
    public function shouldThrowsExceptionIfCouldNotFindListener(): void
    {
        $this->expectException(CouldNotFindListener::class);
        $event = new EventWithoutListener();
        $this->registry->getListenersForEvent($event);
    }

    /**
     * @test
     * @dataProvider dataListenersForEvent
     */
    public function shouldGetListenersForEventWithPriority(object $event, array $expectedListeners): void
    {
        Assert::assertEquals($expectedListeners, $this->registry->getListenersForEvent($event));
    }
}
