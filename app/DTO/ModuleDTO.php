<?php

namespace App\DTO;

use Spatie\TypeScriptTransformer\Attributes\LiteralTypeScriptType;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class ModuleDTO extends DTO
{
    public string $identifier;
    public string $name;
    public string $description;
    public string $type;
    public string $logo;
    #[LiteralTypeScriptType("Record<string, any>[]")]
    public array $options;
    #[LiteralTypeScriptType("Application")]
    public ?ApplicationDTO $application;
}
