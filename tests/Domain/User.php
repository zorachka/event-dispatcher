<?php

declare(strict_types=1);

namespace Zorachka\EventDispatcher\Tests\Domain;

use Zorachka\EventDispatcher\Domain\EventRecordingCapabilities;

final class User
{
    use EventRecordingCapabilities;

    private UserId $id;
    private EmailAddress $emailAddress;

    private function __construct()
    {
    }

    public function register(UserId $id, EmailAddress $emailAddress): self
    {
        $self = new self();
        $self->id = $id;
        $self->emailAddress = $emailAddress;

        $self->registerThat(UserWasRegistered::withEmailAddress($emailAddress));

        return $self;
    }
}
