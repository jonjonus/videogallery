<?php namespace App;

use App\Tagtype;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Video extends Model
{

    use SoftDeletes;
    //    public function __construct()
//    {
//        parent::__construct();
//        $this->tag_types = Tagtype::all()->keyBy('name');
//        $this->tag_types_names = $this->tag_types->pluck('name')->toArray();
//        $this->appends = array_merge(['is_new', 'show_client', 'actions'], $this->tag_types_names);
//    }
//
//    function __call($method, $parameters){
//        $column_name = str_replace('get','',$method);
//        $column_name = strtolower(str_replace('Attribute','',$column_name));
//
//        //catch methods for tag columns and return tag array for type
//        if (in_array($column_name, $this->tag_types_names)){
//            $tag_type_id = $this->tag_types[$column_name]->id;
//            return $this->tags->where('tagtype_id', $tag_type_id)->toArray();
//        }
//        //TODO find a way to call the parent method and not overwrite the whole function
//        //call parent method in child scope
//        if (in_array($method, ['increment', 'decrement'])) {
//            return call_user_func_array([$this, $method], $parameters);
//        }
//
//        $query = $this->newQuery();
//
//        return call_user_func_array([$query, $method], $parameters);
//    }
//
//    private $tag_types;
//    private $tag_types_names;

    protected $fillable = [
        'service_id',
    	'cloud_id',
        'embed',
		'thumbnail',
		'thumbnail_sm',
		'thumbnail_hq',
        'title',
		'name',
		'description',
		'produced_at',
		'url',
		'count_reposts',
		'count_watch',
		'count_likes',
		'ignore',
		'new',
        'client_id',
        'duration'
    	];

    protected $dates = ['produced_at','deleted_at'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */

//    protected $appends = ['show_client', 'actions'];
    protected $appends = ['show_client'];

    public function scopeIgnored($query)
    {
    	$query->where('ignore', '=', 1);
    }

    public function scopeNotIgnored($query)
    {
        $query->where('ignore', '=', 0);
    }

    public function scopeInPlaylist($query)
    {
        //TODO eseto deberia ser un metodo dela playlist no del video
        $videos = session('videos');
        $query->whereIn('id', $videos);
    }

    public function scopeInSelection($query)
    {
        $videos = session('videosSelected');
    	$query->whereIn('id', $videos);
    }

    /* Accessors */

    //setters

    public function setProducedAtAttribute($date)
    {
        // $this->attributes['produced_at'] = Carbon::createFromFormat('Y-m-d', $date);
        $this->attributes['produced_at'] = Carbon::parse($date);
    }

    public function setIgnoreAttribute($ignore)
    {
        $this->attributes['ignore'] = $ignore == 'on' ? 1 : 0;
    }

    public function setClientIdAttribute($client_id)
    {
        $this->attributes['client_id'] = $client_id == '' ? null : $client_id;
    }

    //getters

    public function getThumbnailAttribute()
    {
        return ($this->attributes['thumbnail'] ? $this->attributes['thumbnail'] : $url = asset('/imgs/hqdefault.jpg'));
    }

    public function getThumbnailHqAttribute()
    {
        return ($this->attributes['thumbnail_hq'] ? $this->attributes['thumbnail_hq'] : $url = asset('/imgs/hqdefault.jpg'));
    }

    public function getThumbnailSmAttribute()
    {
        return ($this->attributes['thumbnail_sm'] ? $this->attributes['thumbnail_sm'] : $url = asset('/imgs/hqdefault.jpg'));
    }

    public function getProducedAtAttribute()
    {
        return Carbon::parse($this->attributes['produced_at'])->format("m-Y");
    }

    public function getExtnAttribute()
    {
        return $this->attributes['id'];
    }

//    public function getActionsAttribute()
//    {
//        return view('videos._actions', [
//            'add'    => 'PlaylistsController@add',
//            'remove' => 'PlaylistsController@remove',
//            'view'   => 'VideosController@show',
//            'edit'   => 'VideosController@edit',
//            'delete' => 'VideosController@destroy',
//            'id'     => $this->attributes['id'],
//            'inPlaylist' => $this->inPlaylist,
//        ])->render();
//
//    }

    public function getInPlaylistAttribute()
    {
        $videosIds = session()->get('videos');
        if ($videosIds){
            return in_array($this->id, $videosIds);
        } else {
            return false;
        }
    }

    /* Display Accessors */
    public function getShowMetatextListAttribute(){
        return $this->metatexts->implode('value', ', ');

    }

    public function getShowTagListAttribute(){
        return $this->tags->implode('value', ', ');

    }

    public function getShowClientAttribute(){
        if (isset($this->client)){
            return $this->client->name;
        }
        return "";
    }

    public function getStyledEmbedAttribute()
    {
        if ($this->service->name == 'Vimeo'){
//            return substr_replace($this->embed, ' class="embed-responsive-item"', 7, 0);
            $iframe = preg_replace("/width=\"[0-9]*\"/", 'width="100%"', $this->embed);
            $iframe = preg_replace("/height=\"[0-9]*\"/", 'height="100%"', $iframe);
            return $iframe;
        }
    }

    // public function getProducedAtAttribute()
    // {
    //     // $this->attributes['produced_at'] = Carbon::createFromFormat('Y-m-d', $date);
    //     return Carbon::parse($this->attributes['produced_at'])->format('m/d/Y');
    // }

    /* OTHER FUNCTIONS */
    public function getTagsForType(Tagtype $tagtype)
    {
        return $this->tags->where('tagtype_id', $tagtype->id)->lists('id')->toArray();
    }



    public function hasAttribute($attr)
    {
        return array_key_exists($attr, $this->attributes);
    }

    /**
     * A Video belong to a client
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo('App\Client');
    }

    public function metatexts()
    {
        return $this->belongsToMany('App\Metatext')->withTimeStamps();
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag')->withTimeStamps();
    }

    public function service()
    {
        return $this->belongsTo('App\Service');
    }

//    public function tagtypes()
//    {
//        //                           -final-        -intermediate-  -intermediate_FK-  -final_FK-
//        return $this->hasManyThrough('App\Tagtype', 'App\Tag',      'tagtype_id'      , 'id',      '');
//    }

    public function playlists()
    {
        return $this->belongsToMany('App\Playlist')->withTimeStamps();
    }




}

/*
we can do
$video->tags->lists('name');
to show them
*/