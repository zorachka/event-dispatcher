# Event Dispatcher

[![Latest Version on Packagist](https://img.shields.io/packagist/v/zorachka/event-dispatcher.svg?style=flat-square)](https://packagist.org/packages/zorachka/event-dispatcher)
[![GitHub Workflow Status](https://img.shields.io/github/workflow/status/zorachka/event-dispatcher/run-tests?label=tests)](https://github.com/zorachka/event-dispatcher/actions/workflows/run-tests.yml)
[![Check & fix styling](https://github.com/zorachka/event-dispatcher/workflows/Check%20&%20fix%20styling/badge.svg)](https://github.com/zorachka/event-dispatcher/actions/workflows/php-cs-fixer.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/zorachka/event-dispatcher.svg?style=flat-square)](https://packagist.org/packages/zorachka/event-dispatcher)

---

This is PSR-14 Event Dispatcher pretty simple implementation.

## Installation

You can install the package via composer:

```bash
composer require zorachka/event-dispatcher
```

## Usage

For standalone usage example below. In your entity you need to register event:

```php
<?php

declare(strict_types=1);

namespace Project\Domain;

use Zorachka\EventDispatcher\Domain\EventRecordingCapabilities;

final class Post
{
    use EventRecordingCapabilities;

    private PostId $id;

    private function __construct()
    {
    }

    public static function create(PostId $id): self
    {
        $self = new self();
        $self->id = $id;

        $self->registerThat(PostWasCreated::withId($id));

        return $self;
    }
}

```

Configure `EventDispatcherInterface`:

```php
<?php

declare(strict_types=1);

require __DIR__ . 'vendor/autoload.php';

use Zorachka\EventDispatcher\Infrastructure\ImmutablePrioritizedListenerProvider;
use Zorachka\EventDispatcher\Infrastructure\ListenerPriority;
use Zorachka\EventDispatcher\Infrastructure\PrioritizedListenerProvider;
use Zorachka\EventDispatcher\Infrastructure\SyncEventDispatcher;

use Project\Domain\Post;
use Project\Domain\PostId;
use Project\Domain\PostWasCreated;
use Project\Application\SendEmailToModerator;

use Project\Domain\UserWasRegistered;
use Project\Application\SendWelcomeEmail;

$registry = new ImmutablePrioritizedListenerProvider(
    new PrioritizedListenerProvider(PostWasCreated::class, [
        ListenerPriority::NORMAL => new SendEmailToModerator(),
    ]),
    new PrioritizedListenerProvider(UserWasRegistered::class, [
        ListenerPriority::NORMAL => new SendWelcomeEmail(), 
    ]),
);
$dispatcher = new SyncEventDispatcher($registry);

// And in your application use case:

$post = Post::create(
    PostId::fromString('00000000-0000-0000-0000-000000000000')
);

foreach ($post->releaseEvents() as $event) {
    $dispatcher->dispatch($event);
}

```

Of course that is better to use DI and you can take 
definitions from `ConfigProvider` class. 
After that in your application you can easily inject `EventDispatcherInterface`.


## Testing

```bash
make test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Siarhei Bautrukevich](https://github.com/bautrukevich)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
