<?php

namespace App\Domain\Module\Model;

use Aiken\i18next\i18Next;
use App\Domain\Application\Model\Application;
use App\Helper\Helper;
use DynamicScreen\Today\Today\TodaySlideHandler;
use DynamicScreen\Today\Unsplash\UnsplashAuthProviderHandler;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Module extends Model
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'type',
        'logo',
        'color',
        'description',
        'identifier',
        'application_id',
        'options',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['application'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'options' => 'json',
        'config' => 'json',
    ];

    protected static function boot()
    {
        parent::boot();

        static::retrieved(function($model) {
//            Helper::init_model_translation(Helper::get_active_language(), $model->getTranslationFilesPath());
        });
    }

    public function application(): BelongsTo
    {
        return $this->BelongsTo(Application::class);
    }

    public function getNameAttribute($value)
    {
        return $this->application->i18n->getTranslation($value);
    }

    public function getDescriptionAttribute($value)
    {
        return $this->application->i18n->getTranslation($value);
    }

    public function getLogoAttribute($value)
    {
        return $this->application->i18n->getTranslation($value);
    }

    public function getOption($key, $default = null)
    {
        return Arr::get($this->options, $key, $default);
    }

    public function getTranslationFilesPath()
    {
        return $this->application->getTranslationFilesPath();
    }

    public function getHandlerClass()
    {
        return $this->getOption('php.handler');
    }

    public function getHandler(...$config)
    {
        $path = $this->application->getOption('path') .'/vendor/autoload.php';
        if (!class_exists($path)) {
            if (!$path) return null;

            require_once $path;
        }
        $class = $this->getHandlerClass();

        return new $class(...$config);
    }
}
