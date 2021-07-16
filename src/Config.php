<?php

declare(strict_types=1);

namespace Zorachka\EventDispatcher;

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

    public function addEventListeners(string $eventClassName, array $listeners): self
    {
        $new = clone $this;
        $new->config['listeners'][$eventClassName] = $listeners;

        return $new;
    }
}
