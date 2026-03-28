<?php

declare(strict_types=1);

namespace HardImpact\OpenCode\Resources;

use HardImpact\OpenCode\Data\Worktree;
use HardImpact\OpenCode\Requests\Worktrees\CreateWorktree;
use HardImpact\OpenCode\Requests\Worktrees\ListWorktrees;
use HardImpact\OpenCode\Requests\Worktrees\RemoveWorktree;
use HardImpact\OpenCode\Requests\Worktrees\ResetWorktree;
use Saloon\Http\BaseResource;

class WorktreeResource extends BaseResource
{
    public function create(
        ?string $name = null,
        ?string $startCommand = null,
        ?string $directory = null,
    ): Worktree {
        return $this->connector->send(
            new CreateWorktree($name, $startCommand, $directory)
        )->throw()->dto();
    }

    /** @return string[] */
    public function list(?string $directory = null): array
    {
        return $this->connector->send(
            new ListWorktrees($directory)
        )->throw()->dto();
    }

    public function remove(string $worktreeDirectory, ?string $directory = null): bool
    {
        return $this->connector->send(
            new RemoveWorktree($worktreeDirectory, $directory)
        )->throw()->dto();
    }

    public function reset(string $worktreeDirectory, ?string $directory = null): bool
    {
        return $this->connector->send(
            new ResetWorktree($worktreeDirectory, $directory)
        )->throw()->dto();
    }
}
