<?php

declare(strict_types=1);

namespace Zorachka\EventDispatcher;

use Zorachka\EventDispatcher\Infrastructure\ListenerPriority;

final class Config
{
    private function __construct(private array $config)
    {
    }

    public function build(): array
    {
        return [
            'config' => [
                'event-dispatcher' => $this->config,
            ],
        ];
    }

    public static function withDefaults(): self
    {
        return new self([
            'listeners' => [
//                Event::class => [
//                    ListenerPriority::HIGH => $listener1,
//                    ListenerPriority::NORMAL => $listener2,
//                    ListenerPriority::LOW => $listener3,
//                ],
            ]
        ]);
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

        if ($priority === ListenerPriority::NORMAL) {
            $new->config['listeners'][$eventClassName][] = $listenerClassName;
        } else {
            $new->config['listeners'][$eventClassName][$priority] = $listenerClassName;
        }

        return $new;
    }
}
