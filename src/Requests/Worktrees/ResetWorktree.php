<?php

declare(strict_types=1);

namespace HardImpact\OpenCode\Requests\Worktrees;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

class ResetWorktree extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected string $worktreeDirectory,
        protected ?string $directory = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/experimental/worktree/reset';
    }

    protected function defaultQuery(): array
    {
        return array_filter(['directory' => $this->directory], fn ($value) => $value !== null);
    }

    protected function defaultBody(): array
    {
        return [
            'directory' => $this->worktreeDirectory,
        ];
    }

    public function createDtoFromResponse(Response $response): bool
    {
        return $response->successful();
    }
}
