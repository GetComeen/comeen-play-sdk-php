<?php

namespace App\DTO;

use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class UserDTO extends DTO
{
    public string $user_name;
    public string $full_name;
    public string $email;
    public string $language;
}
