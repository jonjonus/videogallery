<?php namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;
use Log;

class Tagtype extends Model
{
  	protected $fillable = [
    	'name'
    	];

	/**
	 * A TagType can have many tags
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function tags()
	{
		return $this->hasMany('App\Tag');
	}

	public function videos()
	{
		$result = DB::table('videos')
            ->join('tag_video', 'videos.id', '=', 'tag_video.video_id')
            ->get();
//        	Log::info('Tagtype-queries: '.var_export(DB::getQueryLog(), true));
        return $result;
	}

	/* Accessors */
	//TODO still need this?
    public function getLabelAttribute()
    {
        return $this->attributes['name'];
    }

    public function getTagListAttribute()
    {
        return $this->tags->lists('value', 'id')->toArray();
    }
}
