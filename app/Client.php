<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
  	protected $fillable = [
    	'name'
    	];

	/**
	 * A client can have many videos
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function videos()
	{
		return $this->hasMany('App\Video');
	}
}
