<?php

namespace App\DTO;

use Spatie\TypeScriptTransformer\Attributes\LiteralTypeScriptType;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class PrivilegeDTO extends DTO
{
    public string $type;
    #[LiteralTypeScriptType("Record<string, any>[]")]
    public array $options;
    public string $why;
    public string $identifier;
}
