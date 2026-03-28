<?php

declare(strict_types=1);

namespace HardImpact\OpenCode\Requests\Worktrees;

use HardImpact\OpenCode\Data\Worktree;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

class CreateWorktree extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected ?string $name = null,
        protected ?string $startCommand = null,
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

    protected function defaultBody(): array
    {
        return array_filter([
            'name' => $this->name,
            'startCommand' => $this->startCommand,
        ], fn ($value) => $value !== null);
    }

    public function createDtoFromResponse(Response $response): Worktree
    {
        return Worktree::from($response->json());
    }
}
