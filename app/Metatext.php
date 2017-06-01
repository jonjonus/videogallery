<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Metatext extends Model
{
	 protected $fillable = [
    	'name'
    	];
    	
    /**
 	 * Get the videos associated with the given metatext.
 	 * @return \Illuminate\Database\Eloquent\Relations\BelongToMany
 	 */
    public function videos()
    {
    	return $this->belongsToMany('App\Video');
    }
}
