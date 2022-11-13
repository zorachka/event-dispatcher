<?php

declare(strict_types=1);

namespace Zorachka\EventDispatcher\Tests\Unit\EventDispatcher;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Zorachka\EventDispatcher\ListenerPriority;

/**
 * @internal
 */
final class ListenerPriorityTest extends TestCase
{
    /**
     * @test
     */
    public function shouldBeCorrect(): void
    {
        Assert::assertIsInt(ListenerPriority::LOW);

        Assert::assertIsInt(ListenerPriority::NORMAL);
        /** @phpstan-ignore-next-line */
        Assert::assertTrue(ListenerPriority::NORMAL > ListenerPriority::LOW);

        Assert::assertIsInt(ListenerPriority::HIGH);
        /** @phpstan-ignore-next-line */
        Assert::assertTrue(ListenerPriority::HIGH > ListenerPriority::NORMAL);
    }
}
