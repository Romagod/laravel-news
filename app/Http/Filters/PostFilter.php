<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 09.12.2020
 * Time: 12:51
 */

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

trait PostFilter
{
    /**
     * @param Builder $builder
     * @param $value
     * @return Builder
     */
    public function title_like(Builder $builder, $value)
    {
        return $builder->where('title', 'like', '%'.$value.'%');
    }

    /**
     * @param Builder $builder
     * @param $value
     * @return Builder
     */
    public function description_like(Builder $builder, $value)
    {
        return $builder->where('description', 'like', '%'.$value.'%');
    }

    /**
     * @param Builder $builder
     * @return Builder
     */
    public function tags(Builder $builder)
    {
        return $builder->with('tags');
    }

    /**
     * @param Builder $builder
     * @param $value
     * @return Builder
     */
    public function sort_by(Builder $builder, $value)
    {
        if (count($value) > 1) {
            if ($value[1] === 'DESC') {
                return $builder->orderByDesc($value[0]);
            }
        }
        return $builder->orderBy($value[0]);
    }
}