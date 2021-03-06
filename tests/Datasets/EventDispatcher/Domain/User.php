<?php

declare(strict_types=1);

namespace Zorachka\Framework\Tests\Datasets\EventDispatcher\Domain;

use Zorachka\Framework\EventDispatcher\EventRecordingCapabilities;

final class User
{
    use EventRecordingCapabilities;

    private function __construct(
        private UserId $id,
        private EmailAddress $emailAddress,
    ) {
    }

    public function register(UserId $id, EmailAddress $emailAddress): self
    {
        $self = new self($id, $emailAddress);
        $self->registerThat(UserWasRegistered::withEmailAddress($emailAddress));

        return $self;
    }
}
