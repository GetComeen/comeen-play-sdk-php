<?php

namespace App\Domain\Privilege\Model;

use Aiken\i18next\i18Next;
use App\Domain\Application\Model\Application;
use App\Domain\Build\Model\Build;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;

class Privilege extends Model
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'options',
        'why',
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

    public function builds(): BelongsToMany
    {
        return $this->belongsToMany(Build::class)->withTimestamps();
    }

    public function getOption($key)
    {
        return Arr::get($this->options, $key);
    }

    public function getWhyAttribute($value)
    {
        return $this->builds->first()->application->i18n->getTranslation($value);
    }
}
