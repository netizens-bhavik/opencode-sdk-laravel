<?php

namespace HardImpact\OpenCode;

use HardImpact\OpenCode\Resources\EventResource;
use HardImpact\OpenCode\Resources\ProjectResource;
use HardImpact\OpenCode\Resources\ProviderResource;
use HardImpact\OpenCode\Resources\QuestionResource;
use HardImpact\OpenCode\Resources\SessionResource;
use HardImpact\OpenCode\Resources\WorktreeResource;
use Saloon\Http\Auth\BasicAuthenticator;
use Saloon\Http\Connector;

class OpenCode extends Connector
{
    public function __construct(
        protected ?string $baseUrl = null,
        protected ?string $username = null,
        protected ?string $password = null,
    ) {}

    public function defaultAuth(): ?BasicAuthenticator
    {
        if ($this->username !== null && $this->password !== null) {
            return new BasicAuthenticator($this->username, $this->password);
        }

        return null;
    }

    public function resolveBaseUrl(): string
    {
        return $this->baseUrl ?? config('opencode.base_url', 'http://localhost:4096');
    }

    protected function defaultHeaders(): array
    {
        return [
            'Accept' => 'application/json',
        ];
    }

    public function sessions(): SessionResource
    {
        return $this->sessions ??= new SessionResource($this);
    }

    public function events(): EventResource
    {
        return $this->events ??= new EventResource($this);
    }

    public function questions(): QuestionResource
    {
        return $this->questions ??= new QuestionResource($this);
    }

    public function providers(): ProviderResource
    {
        return $this->providers ??= new ProviderResource($this);
    }

    public function projects(): ProjectResource
    {
        return $this->projects ??= new ProjectResource($this);
    }

    public function worktrees(): WorktreeResource
    {
        return $this->worktrees ??= new WorktreeResource($this);
    }

    private ?SessionResource $sessions = null;

    private ?EventResource $events = null;

    private ?QuestionResource $questions = null;

    private ?ProviderResource $providers = null;

    private ?ProjectResource $projects = null;

    private ?WorktreeResource $worktrees = null;
}
