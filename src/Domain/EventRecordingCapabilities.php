<?php

declare(strict_types=1);

namespace Zorachka\EventDispatcher\Domain;

trait EventRecordingCapabilities
{
    /**
     * Array of events to dispatch.
     * @var object[]
     */
    private array $events = [];

    /**
     * Register that event was created.
     * @param object $event
     * @return void
     */
    private function registerThat(object $event): void
    {
        $this->events[] = $event;
    }

    /**
     * Release array of events.
     * @return object[]
     */
    public function releaseEvents(): array
    {
        $events = $this->events;
        $this->events = [];

        return $events;
    }
}
