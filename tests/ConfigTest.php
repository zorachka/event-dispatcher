<?php

declare(strict_types=1);

namespace Zorachka\EventDispatcher\Tests;

use PHPUnit\Framework\TestCase;
use Zorachka\EventDispatcher\Config;
use Zorachka\EventDispatcher\Infrastructure\ListenerPriority;
use Zorachka\EventDispatcher\Tests\Application\SendEmailToModerator;
use Zorachka\EventDispatcher\Tests\Domain\PostWasCreated;

final class ConfigTest extends TestCase
{
    public function testBuild(): void
    {
        $defaultConfig = Config::withDefaults();

        self::assertEquals([
            'config' => [
                'event-dispatcher' => [
                    'listeners' => [],
                ],
            ],
        ], $defaultConfig->build());
    }

    public function testAddEventListener(): void
    {
        $defaultConfig = Config::withDefaults()
            ->addEventListener(
                PostWasCreated::class,
                SendEmailToModerator::class,
            );

        self::assertEquals([
            'config' => [
                'event-dispatcher' => [
                    'listeners' => [
                        PostWasCreated::class => [
                            ListenerPriority::NORMAL => SendEmailToModerator::class,
                        ],
                    ],
                ],
            ],
        ], $defaultConfig->build());
    }
}
