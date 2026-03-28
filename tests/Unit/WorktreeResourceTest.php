<?php

declare(strict_types=1);

use HardImpact\OpenCode\Data\Worktree;
use HardImpact\OpenCode\OpenCode;
use HardImpact\OpenCode\Resources\WorktreeResource;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

test('create returns a worktree', function (): void {
    $mockClient = new MockClient([
        MockResponse::make([
            'name' => 'task-42',
            'branch' => 'task-42',
            'directory' => '/home/user/project/.worktrees/task-42',
        ]),
    ]);

    $connector = new OpenCode('http://localhost:3000');
    $connector->withMockClient($mockClient);

    $resource = new WorktreeResource($connector);
    $worktree = $resource->create(name: 'task-42');

    expect($worktree)->toBeInstanceOf(Worktree::class);
    expect($worktree->name)->toBe('task-42');
    expect($worktree->branch)->toBe('task-42');
    expect($worktree->directory)->toBe('/home/user/project/.worktrees/task-42');
});

test('create with start command', function (): void {
    $mockClient = new MockClient([
        MockResponse::make([
            'name' => 'task-99',
            'branch' => 'task-99',
            'directory' => '/home/user/project/.worktrees/task-99',
        ]),
    ]);

    $connector = new OpenCode('http://localhost:3000');
    $connector->withMockClient($mockClient);

    $resource = new WorktreeResource($connector);
    $worktree = $resource->create(name: 'task-99', startCommand: 'composer setup');

    expect($worktree)->toBeInstanceOf(Worktree::class);
    expect($worktree->name)->toBe('task-99');
});

test('list returns array of worktree directories', function (): void {
    $mockClient = new MockClient([
        MockResponse::make([
            '/home/user/project/.worktrees/task-1',
            '/home/user/project/.worktrees/task-2',
        ]),
    ]);

    $connector = new OpenCode('http://localhost:3000');
    $connector->withMockClient($mockClient);

    $resource = new WorktreeResource($connector);
    $worktrees = $resource->list();

    expect($worktrees)->toHaveCount(2);
    expect($worktrees[0])->toBe('/home/user/project/.worktrees/task-1');
    expect($worktrees[1])->toBe('/home/user/project/.worktrees/task-2');
});

test('remove returns true on success', function (): void {
    $mockClient = new MockClient([
        MockResponse::make('true'),
    ]);

    $connector = new OpenCode('http://localhost:3000');
    $connector->withMockClient($mockClient);

    $resource = new WorktreeResource($connector);
    $result = $resource->remove('/home/user/project/.worktrees/task-1');

    expect($result)->toBeTrue();
});

test('reset returns true on success', function (): void {
    $mockClient = new MockClient([
        MockResponse::make('true'),
    ]);

    $connector = new OpenCode('http://localhost:3000');
    $connector->withMockClient($mockClient);

    $resource = new WorktreeResource($connector);
    $result = $resource->reset('/home/user/project/.worktrees/task-1');

    expect($result)->toBeTrue();
});

test('worktrees accessor is available on connector', function (): void {
    $connector = new OpenCode('http://localhost:3000');

    expect($connector->worktrees())->toBeInstanceOf(WorktreeResource::class);
});
