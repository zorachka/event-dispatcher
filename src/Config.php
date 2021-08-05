<?php

declare(strict_types=1);

namespace Zorachka\EventDispatcher;

use Zorachka\EventDispatcher\Infrastructure\ListenerPriority;

final class Config
{
    private array $config = [];

    private function __construct()
    {
    }

    public function __invoke(): array
    {
        return [
            'config' => [
                'event-dispatcher' => $this->config,
            ],
        ];
    }

    public static function defaults(): self
    {
        $self = new self();
        $self->config = [
            'listeners' => [
//                Event::class => [
//                    ListenerPriority::HIGH => $listener1,
//                    ListenerPriority::NORMAL => $listener2,
//                    ListenerPriority::LOW => $listener3,
//                ],
            ]
        ];

        return $self;
    }

    /**
     * @param class-string $eventClassName
     * @param class-string $listenerClassName
     * @param int $priority
     * @return $this
     */
    public function addEventListener(
        string $eventClassName,
        string $listenerClassName,
        int $priority = ListenerPriority::NORMAL
    ): self {
        $new = clone $this;
        $new->config['listeners'][$eventClassName][$priority] = $listenerClassName;

        return $new;
    }
}
