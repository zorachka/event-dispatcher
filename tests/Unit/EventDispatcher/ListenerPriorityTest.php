<?php

declare(strict_types=1);

use Zorachka\Framework\EventDispatcher\ListenerPriority;

test('ListenerPriority ', function () {
    expect(ListenerPriority::LOW)->toBeInt();

    expect(ListenerPriority::NORMAL)->toBeInt();
    expect(ListenerPriority::NORMAL > ListenerPriority::LOW)->toBeTrue();

    expect(ListenerPriority::HIGH)->toBeInt();
    expect(ListenerPriority::HIGH > ListenerPriority::NORMAL)->toBeTrue();
});
