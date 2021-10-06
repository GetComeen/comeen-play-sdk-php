<?php

namespace App\DTO;

use Illuminate\Support\Carbon;
use Spatie\TypeScriptTransformer\Attributes\LiteralTypeScriptType;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;
use Spatie\TypeScriptTransformer\Attributes\TypeScriptType;

#[TypeScript]
class ApplicationDTO extends DTO
{
    public string $name;
    public string $description;
    public string $type;
    public string $version;
    public string $channel;
    public string $api_level;
    public string $logo;
    #[LiteralTypeScriptType("Record<string, any>[]")]
    public array $options;

    #[LiteralTypeScriptType("Privilege[]")]
    public ?array $privileges;

    #[LiteralTypeScriptType("Module[]")]
    public ?array $modules;
}
