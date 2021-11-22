<?php

declare(strict_types=1);

use Zorachka\Framework\EventDispatcher\NullableEventListener;

test('NullableEventListener should have __invoke method and return object', function () {
    $listener = new NullableEventListener();
    $event = new stdClass();

    expect($listener->__invoke($event))->toBe($event);
});
