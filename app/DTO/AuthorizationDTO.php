<?php

namespace App\DTO;

use Spatie\Enum\Enum;
use Spatie\TypeScriptTransformer\Attributes\LiteralTypeScriptType;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class AuthorizationDTO extends DTO
{
    public string $name;
    public ?string $api_token;
    public string $channel;
    public bool $active;
    #[LiteralTypeScriptType('Application[]')]
    public ?array $applications;
}
