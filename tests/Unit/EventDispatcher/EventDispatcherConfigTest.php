<?php

declare(strict_types=1);

use Zorachka\Framework\EventDispatcher\EventDispatcherConfig;
use Zorachka\Framework\EventDispatcher\ListenerPriority;
use Zorachka\Framework\Tests\Datasets\EventDispatcher\Application\SendEmailToModerator;
use Zorachka\Framework\Tests\Datasets\EventDispatcher\Domain\PostWasCreated;

test('EventDispatcherConfig should be created with defaults', function () {
    $defaultConfig = EventDispatcherConfig::withDefaults();
    $listeners = $defaultConfig->listeners();

    expect($listeners)->toBeArray();
    expect($listeners)->toBeEmpty();
});

test('EventDispatcherConfig should be able to add event listener', function () {
    $defaultConfig = EventDispatcherConfig::withDefaults();
    $newConfig = $defaultConfig->withEventListener(
        PostWasCreated::class,
        SendEmailToModerator::class,
    );

    expect($newConfig->listeners())->toMatchArray([
        PostWasCreated::class => [
            ListenerPriority::NORMAL => SendEmailToModerator::class,
        ],
    ]);
});

test('EventDispatcherConfig should be able to add event listener with priority', function () {
    $defaultConfig = EventDispatcherConfig::withDefaults();
    $newConfig = $defaultConfig->withEventListener(
        PostWasCreated::class,
        SendEmailToModerator::class,
        ListenerPriority::LOW,
    );

    expect($newConfig->listeners())->toMatchArray([
        PostWasCreated::class => [
            ListenerPriority::LOW => SendEmailToModerator::class,
        ],
    ]);
});
