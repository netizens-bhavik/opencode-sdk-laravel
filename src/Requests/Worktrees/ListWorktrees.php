<?php

declare(strict_types=1);

namespace HardImpact\OpenCode\Requests\Worktrees;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class ListWorktrees extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected ?string $directory = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/experimental/worktree';
    }

    protected function defaultQuery(): array
    {
        return array_filter(['directory' => $this->directory], fn ($value) => $value !== null);
    }

    /** @return string[] */
    public function createDtoFromResponse(Response $response): array
    {
        return $response->json();
    }
}
