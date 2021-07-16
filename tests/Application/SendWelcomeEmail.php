<?php

declare(strict_types=1);

namespace Zorachka\EventDispatcher\Tests\Application;

use Zorachka\EventDispatcher\Tests\Domain\UserWasRegistered;

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

    /**
     * @return int
     */
    public function priority(): int
    {
        return $this->priority;
    }

    /**
     * @return bool
     */
    public function isWasCalled(): bool
    {
        return $this->wasCalled;
    }
}
