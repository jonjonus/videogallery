<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
	protected $fillable = [
        'pattern',
        'title',
        'description',
        'password',
	];

    protected $appends = ['protected','url'];

    public function getProtectedAttribute()
    {
        return (isset($this->attributes['password']) && !empty($this->attributes['password']));
    }

    public function getUrlAttribute()
    {
        return (url('player')."/".urlencode($this->attributes['title']));
    }

    /**
 	 * Get the videos associated with the given playlist.
 	 * @return \Illuminate\Database\Eloquent\Relations\BelongToMany
 	 */
    public function videos()
    {
    	return $this->belongsToMany('App\Video')->withTimeStamps();
    }

}
