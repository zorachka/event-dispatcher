<?php

declare(strict_types=1);

namespace Zorachka\EventDispatcher\Tests;

final class SendEmailToModerator
{
    private bool $wasCalled = false;
    private int $priority;

    public function __construct(int $priority = 0)
    {
        $this->priority = $priority;
    }

    public function __invoke(PostWasCreated $event): PostWasCreated
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