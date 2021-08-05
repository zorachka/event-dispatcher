<?php

declare(strict_types=1);

namespace Zorachka\EventDispatcher\Tests;

use PHPUnit\Framework\TestCase;
use Zorachka\EventDispatcher\Config;

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
}
