<?php

declare(strict_types=1);

namespace Zorachka\EventDispatcher\Tests;

use PHPUnit\Framework\TestCase;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\EventDispatcher\ListenerProviderInterface;
use Zorachka\EventDispatcher\ConfigProvider;

final class ConfigProviderTest extends TestCase
{
    public function testConfigure(): void
    {
        $provider = new ConfigProvider();
        $definitions = $provider();

        self::assertEquals([
            ListenerProviderInterface::class,
            EventDispatcherInterface::class,
            'config'
        ], \array_keys($definitions));
    }
}
