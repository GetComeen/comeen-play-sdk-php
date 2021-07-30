<?php


namespace App\Helper;

use Aiken\i18next\i18Next;
use Illuminate\Support\Facades\Auth;

class Helper
{
    public static function getActiveLanguage()
    {
        $lang = 'en';

        if (request()->has('language')) {
            $lang = request()->get('language', 'en');
        } else if (!request()->is('api/*') && Auth::user()) {
            $lang = Auth::user()->language;
        }

        return $lang;
    }

    public static function initModelTranslation($lng, $path) {
        try {
            return new i18Next($lng, $path);
        } catch (\Exception $e) {
            dd('i18next exception init model translation', $e);
        }
    }
}
