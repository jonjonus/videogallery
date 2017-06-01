<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['value','tagtype_id'];
//    protected $appends = ['type'];

    public function getTypeAttribute()
    {
        return ($this->tagtype->name);
    }

    /**
 	 * Get the videos associated with the given tag.
 	 * @return \Illuminate\Database\Eloquent\Relations\BelongToMany
 	 */
    public function videos()
    {
    	return $this->belongsToMany('App\Video')->withTimeStamps();
    }

    /**
     * A Tag belongs to a Tagtype
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tagtype()
    {
        return $this->belongsTo('App\Tagtype');
    }
}
