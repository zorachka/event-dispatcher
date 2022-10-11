<?php

declare(strict_types=1);

namespace Zorachka\EventDispatcher\Tests\Datasets\EventDispatcher\Application;

use Zorachka\EventDispatcher\Tests\Datasets\EventDispatcher\Domain\UserWasRegistered;

final class SendWelcomeEmail
{
    private bool $wasCalled = false;
    private int $priority;

    public function __construct(int $priority = 0)
    {
        $this->priority = $priority;
    }

    public function __invoke(UserWasRegistered $event): UserWasRegistered
    {
        $this->wasCalled = true;

        return $event;
    }

    public function priority(): int
    {
        return $this->priority;
    }

    public function isWasCalled(): bool
    {
        return $this->wasCalled;
    }
}
