<?php

declare(strict_types=1);

namespace HardImpact\OpenCode\Data;

use Spatie\LaravelData\Data;

class Worktree extends Data
{
    public function __construct(
        public string $name,
        public string $branch,
        public string $directory,
    ) {}
}
