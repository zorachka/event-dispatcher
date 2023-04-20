<?php

declare(strict_types=1);

namespace Zorachka\EventDispatcher\Tests\Unit\EventDispatcher;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\EventDispatcher\ListenerProviderInterface;
use Zorachka\EventDispatcher\EventDispatcher;
use Zorachka\EventDispatcher\EventDispatcherConfig;
use Zorachka\EventDispatcher\EventDispatcherServiceProvider;

/**
 * @internal
 */
final class EventDispatcherServiceProviderTest extends TestCase
{
    /**
     * @test
     */
    public function shouldContainDefinitions(): void
    {
        Assert::assertEquals([
            ListenerProviderInterface::class,
            EventDispatcher::class,
            EventDispatcherInterface::class,
            EventDispatcherConfig::class,
        ], array_keys(EventDispatcherServiceProvider::getDefinitions()));
    }
}
