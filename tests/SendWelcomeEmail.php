<?php

declare(strict_types=1);

namespace Zorachka\EventDispatcher\Tests;

final class SendWelcomeEmail
{
    private bool $wasCalled = false;

    public function __invoke(UserWasRegistered $event): UserWasRegistered
    {
        $this->wasCalled = true;

        return $event;
    }

    /**
     * @return bool
     */
    public function isWasCalled(): bool
    {
        return $this->wasCalled;
    }
}
