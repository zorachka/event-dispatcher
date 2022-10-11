<?php

declare(strict_types=1);

namespace Zorachka\EventDispatcher\Tests\Unit\EventDispatcher;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Zorachka\EventDispatcher\EventDispatcherConfig;
use Zorachka\EventDispatcher\ListenerPriority;
use Zorachka\EventDispatcher\Tests\Datasets\EventDispatcher\Application\SendEmailToModerator;
use Zorachka\EventDispatcher\Tests\Datasets\EventDispatcher\Domain\PostWasCreated;

/**
 * @internal
 */
final class EventDispatcherConfigTest extends TestCase
{
    /**
     * @test
     */
    public function shouldBeCreatedWithDefaults(): void
    {
        $defaultConfig = EventDispatcherConfig::withDefaults();
        $listeners = $defaultConfig->listeners();

        Assert::assertIsArray($listeners);
        Assert::assertEmpty($listeners);
    }

    /**
     * @test
     */
    public function shouldBeAbleToAddEventListener(): void
    {
        $defaultConfig = EventDispatcherConfig::withDefaults();
        $newConfig = $defaultConfig->withEventListener(
            PostWasCreated::class,
            SendEmailToModerator::class,
        );

        Assert::assertEquals([
            PostWasCreated::class => [
                ListenerPriority::NORMAL => SendEmailToModerator::class,
            ],
        ], $newConfig->listeners());
    }

    /**
     * @test
     */
    public function shouldBeAbleToAddEventListenerWithPriority(): void
    {
        $defaultConfig = EventDispatcherConfig::withDefaults();
        $newConfig = $defaultConfig->withEventListener(
            PostWasCreated::class,
            SendEmailToModerator::class,
            ListenerPriority::LOW,
        );

        Assert::assertEquals([
            PostWasCreated::class => [
                ListenerPriority::LOW => SendEmailToModerator::class,
            ],
        ], $newConfig->listeners());
    }
}
