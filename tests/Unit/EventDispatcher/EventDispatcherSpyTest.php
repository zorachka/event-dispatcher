<?php

declare(strict_types=1);

use Zorachka\Framework\EventDispatcher\EventDispatcherSpy;

test('EventDispatcherSpy dispatch events', function () {
    $spy = new EventDispatcherSpy();
    $event = new stdClass();

    expect($spy->dispatch($event))->toBe($event);
});

test('EventDispatcherSpy dispatched events', function () {
    $spy = new EventDispatcherSpy();
    $event = new stdClass();

    $spy->dispatch($event);

    expect($spy->dispatchedEvents())->toMatchArray([$event]);
});
