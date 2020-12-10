<?php

namespace App\Eloquent;

use Illuminate\Database\Eloquent\Model;

class PostTags extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'post_tags';
    /**
     * Fillable params
     *
     * @var string[]
     */
    protected $fillable = ['post_id', 'tag_id'];

    /**
     * Gets Posts
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function post()
    {
        return $this->hasOne(Posts::class);
    }

    /**
     * Gets Tags
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function tag()
    {
        return $this->hasOne(Tags::class);
    }
}
