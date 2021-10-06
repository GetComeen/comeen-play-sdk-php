<?php

namespace App\DTO;

use Spatie\TypeScriptTransformer\Attributes\LiteralTypeScriptType;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class BundleDTO extends DTO
{
    public string $name;
    public string $description;

    #[LiteralTypeScriptType("Application[]")]
    public ?array $applications;
}
