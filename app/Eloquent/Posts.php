<?php

namespace App\Eloquent;

use App\Http\Filters\PostFilter;
use eloquentFilter\QueryFilter\ModelFilters\Filterable;
use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    use Filterable;
    use PostFilter;

    /**
     * This is white list for filters
     *
     * @var string[]
     */
    private static $whiteListFilter = [
        'id',
        'title',
        'description',
        'created_at',
        'updated_at',

        // Custom filters:
        'title_like',
        'description_like',
        'tags',
        'sort_by',
    ];

    /**
     * Gets Tags[]
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function tags()
    {
        return $this->hasManyThrough(Tags::class, PostTags::class, 'post_id', 'id', 'id', 'tag_id');
    }

    /**
     * Gets Tags[]
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
