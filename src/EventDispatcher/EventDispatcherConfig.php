<?php

declare(strict_types=1);

namespace Zorachka\Framework\EventDispatcher;

final class EventDispatcherConfig
{
    private function __construct(
        private array $listeners
    ) {}

    public static function withDefaults(array $listeners = []): self
    {
//        [
//            Event::class => [
//                ListenerPriority::HIGH => $listenerOne,
//                ListenerPriority::NORMAL => $listenerTwo,
//                ListenerPriority::LOW => $listenerThree,
//            ],
//        ]
        return new self($listeners);
    }

    /**
     * @param class-string $eventClassName
     * @param class-string $listenerClassName
     * @param int $priority
     * @return $this
     */
    public function withEventListener(
        string $eventClassName,
        string $listenerClassName,
        int $priority = ListenerPriority::NORMAL
    ): self {
        $new = clone $this;

        if ($priority === ListenerPriority::NORMAL) {
            $new->listeners[$eventClassName][] = $listenerClassName;
        } else {
            $new->listeners[$eventClassName][$priority] = $listenerClassName;
        }

        return $new;
    }

    /**
     * @return array
     */
    public function listeners(): array
    {
        return $this->listeners;
    }
}
