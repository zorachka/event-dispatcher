<?php

declare(strict_types=1);

namespace Zorachka\EventDispatcher\Tests\Hook;

use DG\BypassFinals;
use PHPUnit\Runner\BeforeTestHook;

final class BypassFinalsHook implements BeforeTestHook
{
    public function executeBeforeTest(string $test): void
    {
        BypassFinals::enable();
    }
}
