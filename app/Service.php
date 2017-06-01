<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
  	protected $fillable = [
    	'name'
    	];

	/**
	 * A service can have many videos
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function videos()
	{
		return $this->hasMany('App\Video');
	}
}
