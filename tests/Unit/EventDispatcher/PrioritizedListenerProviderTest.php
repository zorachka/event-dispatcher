<?php

declare(strict_types=1);

namespace Zorachka\EventDispatcher\Tests\Unit\EventDispatcher;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Zorachka\EventDispatcher\Exceptions\CouldNotFindListener;
use Zorachka\EventDispatcher\ListenerPriority;
use Zorachka\EventDispatcher\PrioritizedListenerProvider;
use Zorachka\EventDispatcher\Tests\Datasets\EventDispatcher\Application\SendEmailToModerator;
use Zorachka\EventDispatcher\Tests\Datasets\EventDispatcher\Domain\EventWithoutListener;
use Zorachka\EventDispatcher\Tests\Datasets\EventDispatcher\Domain\PostId;
use Zorachka\EventDispatcher\Tests\Datasets\EventDispatcher\Domain\PostWasCreated;

/**
 * @internal
 */
final class PrioritizedListenerProviderTest extends TestCase
{
    private PrioritizedListenerProvider $provider;

    protected function setUp(): void
    {
        $this->provider = new PrioritizedListenerProvider(PostWasCreated::class, [
            ListenerPriority::NORMAL => new SendEmailToModerator(ListenerPriority::NORMAL),
            ListenerPriority::HIGH => new SendEmailToModerator(ListenerPriority::HIGH),
            ListenerPriority::LOW => new SendEmailToModerator(ListenerPriority::LOW),
        ]);
    }

    /**
     * @test
     */
    public function shouldThrowsExceptionIfCouldNotFindListener(): void
    {
        $this->expectException(CouldNotFindListener::class);
        $event = new EventWithoutListener();
        $this->provider->getListenersForEvent($event);
    }

    /**
     * @test
     */
    public function shouldHaveEventClassName(): void
    {
        Assert::assertEquals(PostWasCreated::class, $this->provider->eventClassName());
    }

    /**
     * @test
     */
    public function shouldGetListenersForEventWithPriority(): void
    {
        $event = PostWasCreated::withId(
            PostId::fromString('00000000-0000-0000-0000-000000000000')
        );

        Assert::assertEquals([
            new SendEmailToModerator(ListenerPriority::HIGH),
            new SendEmailToModerator(ListenerPriority::NORMAL),
            new SendEmailToModerator(ListenerPriority::LOW),
        ], $this->provider->getListenersForEvent($event));
    }
}
