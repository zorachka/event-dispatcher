<?php

declare(strict_types=1);


use Zorachka\Framework\Tests\Datasets\EventDispatcher\Domain\Post;
use Zorachka\Framework\Tests\Datasets\EventDispatcher\Domain\PostId;
use Zorachka\Framework\Tests\Datasets\EventDispatcher\Domain\PostWasCreated;

test('EventRecordingCapabilities should release events', function () {
    $post = Post::create(
        $id = PostId::fromString('00000000-0000-0000-0000-000000000000'),
    );

    expect($post->releaseEvents())->toMatchArray([
        PostWasCreated::withId($id),
    ]);
});
