<?php

namespace App\DTO;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class DTO extends DataTransferObject
{
    public int $id = 0;
    public bool $__exists = false;

    /**
     * @throws UnknownProperties
     */
    final public static function make(Model $model) : static
    {
        return new static(array_merge($model->toArray(), [
            "__exists" => $model->exists
        ]));
    }

    final public static function collection(Collection|array $collection)
    {
        return collect($collection)->map(fn (Model $model) => static::make($model))->toArray();
    }

    /**
     * @throws UnknownProperties
     */
    final public static function paginated(LengthAwarePaginator $paginator)
    {
        return new PaginatorDTO($paginator->toArray());
    }
}
