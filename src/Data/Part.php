<?php

namespace HardImpact\OpenCode\Data;

use HardImpact\OpenCode\Enums\PartType;
use HardImpact\OpenCode\Enums\ToolStatus;
use Spatie\LaravelData\Data;

class Part extends Data
{
    public static function fromTolerant(mixed $data): ?self
    {
        if (! is_array($data)) {
            return null;
        }

        $type = PartType::tryFrom($data['type'] ?? '') ?? PartType::Unknown;

        $state = null;
        if (isset($data['state']) && is_array($data['state'])) {
            $status = ToolStatus::tryFrom($data['state']['status'] ?? '') ?? ToolStatus::Unknown;
            $state = new ToolState(
                status: $status,
                input: $data['state']['input'] ?? null,
                output: $data['state']['output'] ?? null,
                error: $data['state']['error'] ?? null,
                title: $data['state']['title'] ?? null,
                metadata: $data['state']['metadata'] ?? null,
                time: $data['state']['time'] ?? null,
                attachments: $data['state']['attachments'] ?? null,
            );
        }

        return new self(
            id: $data['id'],
            type: $type,
            messageID: $data['messageID'],
            sessionID: $data['sessionID'],
            text: $data['text'] ?? null,
            mime: $data['mime'] ?? null,
            url: $data['url'] ?? null,
            filename: $data['filename'] ?? null,
            tool: $data['tool'] ?? null,
            callID: $data['callID'] ?? null,
            state: $state,
            snapshot: $data['snapshot'] ?? null,
            files: $data['files'] ?? null,
            hash: $data['hash'] ?? null,
            cost: isset($data['cost']) ? (float) $data['cost'] : null,
            tokens: $data['tokens'] ?? null,
            reason: $data['reason'] ?? null,
            synthetic: $data['synthetic'] ?? null,
            time: $data['time'] ?? null,
            metadata: $data['metadata'] ?? null,
            source: $data['source'] ?? null,
        );
    }

    public function __construct(
        public string $id,
        public PartType $type,
        public string $messageID,
        public string $sessionID,
        public ?string $text = null,
        public ?string $mime = null,
        public ?string $url = null,
        public ?string $filename = null,
        public ?string $tool = null,
        public ?string $callID = null,
        public ?ToolState $state = null,
        public ?string $snapshot = null,
        public ?array $files = null,
        public ?string $hash = null,
        public ?float $cost = null,
        public ?array $tokens = null,
        public ?string $reason = null,
        public ?bool $synthetic = null,
        public ?array $time = null,
        public ?array $metadata = null,
        public ?array $source = null,
    ) {}
}
