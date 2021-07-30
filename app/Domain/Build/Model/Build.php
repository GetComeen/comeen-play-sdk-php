<?php

namespace App\Domain\Build\Model;

use Aiken\i18next\i18Next;
use App\Domain\Application\Model\Application;
use App\Domain\Privilege\Model\Privilege;
use App\Domain\Resource\Model\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class Build extends Model
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'path',
        'version',
        'channel',
        'api_level',
        'api_level',
        'application_id',
    ];

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
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    public function privileges(): BelongsToMany
    {
        return $this->belongsToMany(Privilege::class)->withTimestamps();
    }

    public function resources(): HasMany
    {
        return $this->hasMany(Resource::class);
    }

    public function scopeSlideType(Builder $query): Builder
    {
        return $query->where('type', 'slide');
    }

    public function scopeOptionsType(Builder $query): Builder
    {
        return $query->where('type', 'options');
    }

    public function getApiLevelAttribute($value)
    {
        return $this->application->i18n->getTranslation($value);
    }

    public function getVersionAttribute($value)
    {
        return $this->application->i18n->getTranslation($value);
    }
}
