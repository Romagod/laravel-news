<?php

namespace App\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ["name"];

    /**
     * Check and create new tags
     *
     * @param $tags
     * @param null $id
     * @return \Illuminate\Support\Collection
     */
    public static function checkTags($tags, $id = null)
    {
        $tagsCollect = collect([]);
        foreach ($tags as $tagName) {
            $tag = Tags::firstOrCreate(['name' => $tagName]);
            if ($id !== null) {
                $postsTags = PostTags::firstOrCreate(['post_id' => $id, 'tag_id' => $tag->id]);
            }
            $tagsCollect->push($tag);
        }

        return $tagsCollect;
    }
}
