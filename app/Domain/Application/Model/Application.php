<?php

namespace App\Domain\Application\Model;

use Aiken\i18next\i18Next;
use App\Domain\Authorization\Model\Authorization;
use App\Domain\Build\Model\Build;
use App\Domain\Bundle\Model\Bundle;
use App\Domain\Module\Model\Module;
use App\Helper\Helper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

class Application extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'logo',
        'version',
        'channel',
        'api_level',
        'color',
        'type',
        'author',
        'import_type',
        'options',
    ];

    public $i18n;
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

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
            $model->i18n = Helper::init_model_translation(Helper::get_active_language(), $model->getTranslationFilesPath());
        });
    }

    public function builds(): HasMany
    {
        return $this->hasMany(Build::class);
    }

    public function bundles(): BelongsToMany
    {
        return $this->belongsToMany(Bundle::class)->withTimestamps();
    }

    public function authorizations(): BelongsToMany
    {
        return $this->belongsToMany(Authorization::class)->withTimestamps();
    }

    public function modules(): HasMany
    {
        return $this->hasMany(Module::class);
    }

    public function getNameAttribute($value)
    {
        return $this->i18n->getTranslation($value);
    }

    public function getDescriptionAttribute($value)
    {
        return $this->i18n->getTranslation($value);
    }

    public function getLogoAttribute($key)
    {
        $value = $this->i18n->getTranslation($key);
        if (Str::startsWith($value, './')) {
            $value = asset('storage/'.pathinfo($value, PATHINFO_BASENAME));
        }
        return $value;
    }

    public function getOption($key)
    {
        return Arr::get($this->options, $key);
    }

    public function getTranslationFilesPath()
    {
        return $this->getOption('path'). "/languages/__lng__.json";
    }
}
