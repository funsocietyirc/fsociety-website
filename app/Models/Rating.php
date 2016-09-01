<?php

namespace Fsociety\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Fsociety\Models\Rating
 *
 * @property integer $id
 * @property integer $rating
 * @property integer $ratingable_id
 * @property string $ratingable_type
 * @property integer $author_id
 * @property string $author_type
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $ratingable
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $author
 * @method static \Illuminate\Database\Query\Builder|\Fsociety\Models\Rating whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Fsociety\Models\Rating whereRating($value)
 * @method static \Illuminate\Database\Query\Builder|\Fsociety\Models\Rating whereRatingableId($value)
 * @method static \Illuminate\Database\Query\Builder|\Fsociety\Models\Rating whereRatingableType($value)
 * @method static \Illuminate\Database\Query\Builder|\Fsociety\Models\Rating whereAuthorId($value)
 * @method static \Illuminate\Database\Query\Builder|\Fsociety\Models\Rating whereAuthorType($value)
 * @method static \Illuminate\Database\Query\Builder|\Fsociety\Models\Rating whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Fsociety\Models\Rating whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Rating extends Model
{
    /**
     * @var string
     */
    protected $table = 'ratings';

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function ratingable()
    {
        return $this->morphTo();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function author()
    {
        return $this->morphTo('author');
    }

    /**
     * @param Model $ratingable
     * @param $data
     * @param Model $author
     *
     * @return static
     */
    public function createRating(Model $ratingable, $data, Model $author)
    {
        /** @var Rating $rating */
        $rating = static::whereId($this->id)->whereAuthorId($author->id)->first();

        // Rating already exists
        if($rating) {
            $rating->update($data);
            return $rating;
        }

        $rating = new static();
        $rating->fill(array_merge($data, [
            'author_id' => $author->id,
            'author_type' => get_class($author),
        ]));

        $ratingable->ratings()->save($rating);
        return $rating;
    }

    /**
     * @param $id
     * @param $data
     *
     * @return mixed
     */
    public function updateRating($id, $data)
    {
        $rating = static::find($id);
        $rating->update($data);

        return $rating;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function deleteRating($id)
    {
        return static::find($id)->delete();
    }
}