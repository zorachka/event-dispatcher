<?php

declare(strict_types=1);

namespace Zorachka\EventDispatcher;

final class EventDispatcherConfig
{
    private function __construct(
        /**
         * @var array<class-string, array<int, class-string>> $listeners
         */
        private array $listeners
    ) {
    }

    /**
     * @param array<class-string, array<int, class-string>> $listeners
     * @return static
     */
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
     * @return $this
     */
    public function withEventListener(
        string $eventClassName,
        string $listenerClassName,
        int $priority = ListenerPriority::NORMAL
    ): self {
        $new = clone $this;
        $new->listeners[$eventClassName][$priority] = $listenerClassName;

        return $new;
    }

    /**
     * @return array<class-string, array<int, class-string>> $listeners
     */
    public function listeners(): array
    {
        return $this->listeners;
    }
}
