<?php

declare(strict_types=1);

namespace Zorachka\EventDispatcher\Tests\Infrastructure;

use PHPUnit\Framework\TestCase;
use Zorachka\EventDispatcher\Infrastructure\ListenerPriority;
use Zorachka\EventDispatcher\Infrastructure\PrioritizedListenerProvider;
use Zorachka\EventDispatcher\Tests\PostId;
use Zorachka\EventDispatcher\Tests\PostWasCreated;
use Zorachka\EventDispatcher\Tests\SendEmailToModerator;

final class PrioritizedListenerProviderTest extends TestCase
{
    private PrioritizedListenerProvider $provider;

    protected function setUp(): void
    {
        parent::setUp();
        $this->provider = new PrioritizedListenerProvider(PostWasCreated::class, [
            ListenerPriority::NORMAL => new SendEmailToModerator(ListenerPriority::NORMAL),
            ListenerPriority::HIGH => new SendEmailToModerator(ListenerPriority::HIGH),
            ListenerPriority::LOW => new SendEmailToModerator(ListenerPriority::LOW),
        ]);
    }

    public function testClassName(): void
    {
        self::assertEquals(PostWasCreated::class, $this->provider->eventClassName());
    }

    public function testGetListenersForEventWithPriority(): void
    {
        $event = PostWasCreated::withId(
            PostId::fromString('00000000-0000-0000-0000-000000000000')
        );

        $this->assertEqualsCanonicalizing([
            new SendEmailToModerator(ListenerPriority::HIGH),
            new SendEmailToModerator(ListenerPriority::NORMAL),
            new SendEmailToModerator(ListenerPriority::LOW),
        ], $this->provider->getListenersForEvent($event));
    }
}
