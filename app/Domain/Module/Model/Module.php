<?php

namespace App\Domain\Module\Model;

use Aiken\i18next\i18Next;
use App\Domain\Application\Model\Application;
use App\Helper\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

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
        'description',
        'identifier',
//        'application_id',
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
    ];

    protected static function boot()
    {
        parent::boot();

        static::retrieved(function($model) {
//            Helper::initModelTranslation(Helper::getActiveLanguage(), $model->getTranslationFilesPath());
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

    public function getOption($key)
    {
        return Arr::get($this->options, $key);
    }

    public function getTranslationFilesPath()
    {
        return $this->application->getTranslationFilesPath();
    }
}
