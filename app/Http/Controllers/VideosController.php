<?php namespace App\Http\Controllers;

use App\Playlist;
use App\Service;
use DB;
use App\Video;
use App\Client;
use App\Metatext;
use App\Tag;
use App\Tagtype;
use App\Http\Requests;
// use App\Http\Requests\Request;
use App\Http\Requests\CreateVideoRequest;
use App\Http\Requests\EditVideoRequest;
use App\Http\Requests\EditBulkVideoRequest;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

// use Request;

class VideosController extends Controller
{
    public function __construct()
    {

        //$this->middleware('auth', ['only' => 'create']); //if we want to apply it to a specific route
        ////$this->middleware('auth', ['except' => 'create']); // alternatevly
        $this->middleware('auth');
    }

    public function index()
    {
        $actionNew = 'VideosController@create';
        $actionEditBulk = 'VideosController@editBulk';
        $actionDeleteBulk = 'VideosController@destroyBulk';
        $clients = Client::orderBy('name', 'asc')->get(array('id', 'name'));
        $tagTypes = Tagtype::all();

        // we get the video objects for those IDs in the playlist (session) but it might not be ordered the same way,
        // how it was dragged and dropped, it comes how it is ordered in the DB.
        $playlist_videos = Video::InPlaylist()->get(); // returns a colletion of App\Video
        //so we need to re order it to match the playlist
        $order = session()->get('videos');
        $playlist_videos = $playlist_videos->sort(function ($a, $b) use ($order) {
            $pos_a = array_search($a->id, $order);
            $pos_b = array_search($b->id, $order);
            return $pos_a - $pos_b;
        });

        $playlist_id  = session()->get('playlist_id');
        $playlist_obj = ($playlist_id ? Playlist::find($playlist_id) : null);

        return view('videos.index', compact(
                'actionNew',
                'actionEditBulk',
                'actionDeleteBulk',
                'playlist_videos',
                'playlist_obj',
                'clients',
                'tagTypes'
            )
        );
    }

    public function create()
    {
        $clients = Client::lists('name', 'id')->toArray();
        $metatexts = Metatext::lists('name', 'id')->toArray();
        $tagtypes = Tagtype::all();
        $services = Service::lists('name', 'id')->toArray();
        return view('videos.create', compact('clients', 'metatexts', 'tagtypes', 'services'));
    }

    /**
     * Show a single video.
     * @param  Video $video
     * @return Response
     */
    public function show(Video $video)
    {
        $clients = Client::lists('name', 'id')->toArray();
        $metatexts = Metatext::lists('name', 'id')->toArray();
        $tagtypes = Tagtype::all();
        // $video = Video::findOrFail($id); //since usign Rpute Model Binding we automatically get a Video object
        return view('videos.show', compact('video', 'clients', 'metatexts', 'tagtypes'));
    }

    public function edit(Video $video)
    {
        $clients = Client::lists('name', 'id')->toArray();
        $metatexts = Metatext::orderBy('name', 'asc')->lists('name', 'id')->toArray();
        $tagtypes = Tagtype::all();
        $action = 'VideosController@update';
        $services = Service::lists('name', 'id')->toArray();
        return view('videos.edit', compact('video', 'clients', 'metatexts', 'tagtypes', 'action', 'services'));
    }

    public function editBulk(Request $request)
    {
        $clients   = Client::lists('name', 'id')->toArray();
        $services  = Service::lists('name','id')->toArray();
        $metatexts = Metatext::lists('name', 'id')->toArray();
        $tagtypes  = Tagtype::all();
        $videos    = Video::InSelection()->get();
        $video     = new Video;
		return view('videos.editBulk', compact('video', 'videos', 'clients', 'metatexts', 'tagtypes', 'services'));
	}

    public function store(CreateVideoRequest $request)
    {
        $video = Video::create($request->all());
        $this->syncMetaTexts($video, $request);
        $this->syncTags($video, $request);

        return redirect(action('VideosController@index'));
    }

    public function update(Video $video, EditVideoRequest $request)
    {
        // $video = Video::findOrFail($id);  //since usign Rpute Model Binding we autimatically get a Video object
        $video->update($request->all());
        $this->syncMetaTexts($video, $request);
        $this->syncTags($video, $request);

        return redirect('videos');
    }

    public function updateField(Video $video, Request $request)
    {
        $field = $request->get("field");
        $value = $request->get("value");

        $video->$field = $value;
        try {
            $video->save();
        } catch (Exception $e) {
            header('HTTP/1.1 500 (' . $e->getCode() . ') ' . $e->getMessage());
            header('Content-Type: application/json; charset=UTF-8');
            echo json_encode(array(
                "result" => "error",
                "message" => "An error occurred trying to save the field (" . $e->getCode() . " - " . $e->getMessage() . ")",
                "error" => $e->getMessage(),
                "code" => $e->getCode(),
            ));
            exit;
        }
        return response(['result' => 'ok']);
    }

    public function updateBulk(Video $video, EditBulkVideoRequest $request)
    {
        //TODO el manejo de estos fields puede hacerse en la clase EditBulkVideoRequest
        $fields = $request->all();
        $fields = array_filter($fields, function ($v, $k) {
            return !empty($v) && $k != '_token' && $k != 'ids';
        }, ARRAY_FILTER_USE_BOTH);
        //format date
        if (isset($fields['produced_at'])) {
            $fields['produced_at'] = Carbon::parse($fields['produced_at'])->format('Y-m-d H:i:s');
        }
        DB::table('videos')
            ->whereIn('id', session()->get('videosSelected'))
            ->update($fields);

        return redirect('videos');
    }

    public function destroy(Video $video)
    {
        $video->delete();
        return redirect('videos');
    }

    public function destroyBulk(Request $request)
    {
        $videosSelected = $request->session()->get('videosSelected');
        foreach ($videosSelected as $videoId) {
            $video = Video::find($videoId);
            $video->delete();
        };
        $request->session()->forget('videosSelected');
        return redirect('videos');
    }

    public function embedCode(Video $video)
    {
        //TODO get from API
        if (!$video->embed && $video->service->name == 'Youtube') {
            return response()->json(array(
                'result' => 'ok',
                'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/' . $video->cloud_id . '" frameborder="0" allowfullscreen></iframe>',
                'title'  => $video->title,
                'errors' => ''));
        } elseif ($video->embed) {

            $iframe = preg_replace("/width=\"[0-9]*\"/", 'width="100%"', $video->embed);
            $iframe = preg_replace("/height=\"[0-9]*\"/", 'height="auto"', $iframe);

            return response()->json(array(
                'result' => 'ok',
                'embed' => $iframe,
                'title'  => $video->title,
                'errors' => ''));
        }
        return response()->json(array(
            'result' => 'error',
            'embed'  => '',
            'title'  => $video->title,
            'errors' => 'Sorry, video not available'));
    }

    /* SELECTION */

    public function selection_add(Video $video)
    {
        //TODO will laravel make a json response automatically because is an ajax request?
        $videosSelected = session()->get('videosSelected');
        if (count($videosSelected) && in_array($video->id, $videosSelected)) {
            header('HTTP/1.1 500 The video is already selected');
            header('Content-Type: application/json; charset=UTF-8');
            echo json_encode(array("result" => 'The video is already selected'));
            exit;
        } else {
            session()->push('videosSelected', strval($video->id));
            return response(['result' => 'Video added to selection', 'code' => 1]);
        }
    }

    public function selection_remove(Video $video)
    {
        $videosSelected = session()->get('videosSelected');
        if (is_array($videosSelected)) {
            $key = array_search($video->id, $videosSelected);
        } else {
            header('HTTP/1.1 500 The video was not found in the selection');
            header('Content-Type: application/json; charset=UTF-8');
            echo json_encode(array("result" => 'The video selection is empty'));
            exit;
        }
        if (!count($videosSelected) || $key === false) {
            header('HTTP/1.1 500 The video was not found in the selection');
            header('Content-Type: application/json; charset=UTF-8');
            echo json_encode(array("result" => 'The video was not found in the selection'));
            exit;
        } else {
            unset($videosSelected[$key]);
            session()->put('videosSelected', $videosSelected);
            return response(['result' => 'Video unselected', 'code' => 0]);
        }
    }

    public function selection_update(Request $request)
    {
        $videosSelected = $request->get('ids');
        if (!is_array($videosSelected)) {
            header('HTTP/1.1 500 Invalid parameters');
            header('Content-Type: application/json; charset=UTF-8');
            echo json_encode(array("result" => 'error', 'message' => 'Invalid parameters'));
            exit;
        }

        if (!count($videosSelected)) {
            header('HTTP/1.1 500 No videos to add');
            header('Content-Type: application/json; charset=UTF-8');
            echo json_encode(array("result" => 'error', 'message' => 'No videos to add'));
            exit;
        }

        $request->session()->put('videosSelected', $videosSelected);

        return response(['result' => 'ok']);

    }

    public function selection_show(Request $request)
    {
        dd($request->session()->get('videosSelected'));
    }

    public function selection_many_remove(Request $request)
    {
        $videosSelected = $request->get('ids');
        if (!is_array($videosSelected)) {
            header('HTTP/1.1 500 Invalid parameters');
            header('Content-Type: application/json; charset=UTF-8');
            echo json_encode(array("result" => 'Invalid parameters'));
            exit;
        }

        if (!count($videosSelected)) {
            header('HTTP/1.1 500 No videos to remove');
            header('Content-Type: application/json; charset=UTF-8');
            echo json_encode(array("result" => 'No videos to remove'));
            exit;
        }

        $videosSelected = array_diff($request->session()->get('videosSelected'), $videosSelected);
        $request->session()->put('videosSelected', $videosSelected);
    }

    public function selection_all_remove(Request $request)
    {
        $request->session()->forget('videosSelected');
        // dd($request->session()->all());
    }

    public function showPanel()
    {
        return view('common.selection');
    }

    /* METATEXTS AND TAGS */

    private function syncMetaTexts(Video $video, Request $request)
    {
        // if ($request->input('metatext_list')){}
        $allMetatexts = $this->createAndAppendNewMetatexts($request->input('metatexts'));
        $video->metatexts()->sync($allMetatexts);
        return $video;
    }

    private function syncTags(Video $video, Request $request)
    {
        $allTags = [];
        $tagtypes = Tagtype::all();
        foreach ($tagtypes as $tagtype) {
            if ($request->input($tagtype->name . '_list')) {
                $allTags = array_merge($allTags, $this->createAndAppendNewTags($request->input($tagtype->name . '_list'), $tagtype));
            }
        }
        $video->tags()->sync($allTags);
        return $video;
    }

    private function createAndAppendNewMetatexts(array $metatexts = NULL)
    {
        if ($metatexts) {
            $existentMetatexts = Metatext::lists('name', 'id')->toArray();
            $newMetatexts = array_flip(array_diff_key(array_flip($metatexts), $existentMetatexts));
            foreach ($newMetatexts as $newMetatextKey => $newMetatextName) {
                $obj_newMetatext = Metatext::create(['name' => $newMetatextName]);
                $metatexts[$newMetatextKey] = $obj_newMetatext->id;
            }
            return $metatexts;
        } else {
            return array();
        }
    }

    private function createAndAppendNewTags(array $inputTags, Tagtype $tagtype)
    {
        $existentTags = $tagtype->tagList;
        $newTags = array_flip(array_diff_key(array_flip($inputTags), $existentTags));
        foreach ($newTags as $newTagKey => $newTagValue) {
            $obj_newTag = Tag::create(['value' => $newTagValue, 'tagtype_id' => $tagtype->id]);
            $inputTags[$newTagKey] = $obj_newTag->id;
        }
        return $inputTags;
    }

    private function rutime($ru, $rus, $index) {
        return ($ru["ru_$index.tv_sec"]*1000 + intval($ru["ru_$index.tv_usec"]/1000))
         -  ($rus["ru_$index.tv_sec"]*1000 + intval($rus["ru_$index.tv_usec"]/1000));
    }

    /* DATATABLES */
    public function datatables_load($videoId = null)
    {
        $time_start = microtime(true);

        //metatexts
        $metatexts = Metatext::get()->keyBy('id');

        //tags
        $tags = Tag::with('tagtype')->get()->keyBy('id');

        //clients
        $clients = Client::get()->keyBy('id');

        //tagtypes
        $tagtypes = Tagtype::with('tags')->get()->keyBy('id');
        $tagtypes_arr = [];
        //TODO mejorar con funciones de array tipo pupular un array con la concatenacion de las keys y despues usarlo de input
        foreach ($tagtypes as $tagtype) {
            //create them all so there is not a reference to null in the future
            $tagtypes_arr["tags_" . $tagtype->id] = [];
        }
        // TODO xq use stdclass en lugar de la clase video?
        $videos = DB::table('videos')
            ->leftJoin('metatext_video', 'videos.id', '=', 'metatext_video.video_id')
            ->leftJoin('tag_video', 'videos.id', '=', 'tag_video.video_id')
            ->leftJoin('services', 'videos.service_id', '=', 'services.id')
            ->select('videos.*', 'services.name AS service_name', DB::raw('group_concat(DISTINCT metatext_video.metatext_id) AS metatexts_ids'), DB::raw('group_concat(DISTINCT tag_video.tag_id) AS tags_ids'))
            ->when($videoId, function ($query) use ($videoId) {
                return $query->where('videos.id', $videoId);
            })
            ->groupBy('videos.id')
            ->get();

        //map object into json array
        $videos_arr = [];

        $ids_in_playlist = session()->get('videos');
        if (!$ids_in_playlist) $ids_in_playlist = []; //otherwise in_array for actions below fails

        $csrf = csrf_field();

        foreach ($videos as $video) {
            $video_arr = [];
            $video_arr['id'] = $video->id;
            $video_arr['cloud_id'] = $video->cloud_id;
            $video_arr['thumbnail'] = $video->thumbnail_hq;
            $video_arr['title'] = $video->title;
            $video_arr['name'] = $video->name;
            $video_arr['description'] = $video->description;
            $video_arr['duration'] = $video->duration;
            $video_arr['produced_at'] = $video->produced_at;
            $video_arr['url'] = $video->url;
            $video_arr['ignore'] = ($video->ignore ? 1 : 0);
            $video_arr['new'] = ($video->new ? 1 : 0);

            //actions

            if (in_array($video->id, $ids_in_playlist)){
                $addHTML    = 'style="display:none;"';
                $removeHTML = '';
            } else {
                $addHTML    = '';
                $removeHTML = 'style="display:none;"';
            }

            $actionsHTML = '
                    <form data-id="'.$video->id.'"
                          method="POST"
                          action="'.action('PlaylistsController@add', [$video->id]).'"
                          accept-charset="UTF-8"
                          class="form-add"
                          '.$addHTML.'>
                        <button type="submit" class="btn btn-xs btn-success btn-playlist-panel"><i class="fa fa-btn fa-plus"></i></button>
                        '.$csrf.'
                        <input type="hidden" name="_method" value="put">
                    </form>
                    
                    <form data-id="'.$video->id.'"
                          method="POST"
                          action="'.action('PlaylistsController@remove', [$video->id]).'"
                          accept-charset="UTF-8"
                          class="form-remove"
                          '.$removeHTML.'>
                        <button type="submit" class="btn btn-xs btn-warning btn-playlist-panel"><i class="fa fa-btn fa-minus"></i></button>
                        '.$csrf.'
                        <input type="hidden" name="_method" value="delete" />
                    ';

            $video_arr['actions'] = $actionsHTML;

            //metatexts
            $video_arr['metatexts'] = [];
            if ($video->metatexts_ids){
                foreach (explode(",",$video->metatexts_ids) as $metatext_id) {
                    $video_arr['metatexts'][] = array('id' => $metatext_id, 'name' => $metatexts->get($metatext_id)->name);
                }
            }
            //tags
            $video_arr = array_merge($video_arr, $tagtypes_arr);
            if ($video->tags_ids){
                foreach (explode(",",$video->tags_ids) as $tag) {
                    $video_arr["tags_" . $tags->get($tag)->tagtype->id][] = array('id' => $tag, 'value' => $tags->get($tag)->value);
                }
            }
            //client
            $video_arr['client']['id']    = $video->client_id;
            $video_arr['client']['name']  = ($video->client_id ? $clients->get($video->client_id)->name : null);
            //service
            $video_arr['service']['id']   = $video->service_id;
            $video_arr['service']['name'] = $video->service_name;

            $videos_arr[] = $video_arr;
        }

        unset($videos);

        //options
        $options["client.id"] = $clients->pluck('id','name')->toArray();
        $options["metatexts[].id"] = $metatexts->pluck('id','name')->toArray();

        foreach ($tagtypes as $tt) {
            $tags_arr = [];
            foreach ($tt->tags as $tag) {
                $tags_arr[$tag->value] = $tag->id;
            }
            $options["tags_" . $tt->id . "[].id"] = $tags_arr;
        }
        $time_end = microtime(true);

        return response()->json(array(
            'data'         => $videos_arr,
            'options'      => $options,
            'selection'    => session()->get('videosSelected'),
            'time'         => ($time_end - $time_start),
        ));
    }

    public function datatables_update(Request $request)
    {
        $attributes = $request->get("data");
        $videoId = array_keys($attributes)[0];
        $video = Video::findOrFail($videoId); //Video::whereIn('id', $videoIds)->with('metatexts', 'tags')->get()->keyBy('id');
        // Single-Value-Columns
        $svc = $video->getFillable();

        // Multiple-Value-Columns
//        $mvc = ['metatexts'];
        $tagtypes_objs = Tagtype::all()->keyBy('id');
//        $tagtypes = Tagtype::lists('name')->toArray();
//        array_walk($tagtypes, function (&$e) {
//            $e = 'tags_' . $e;
//        });
//        $mvc = array_merge($mvc, $tagtypes);

        try {
            $allTags = [];
            $allMetatexts = [];

            foreach ($attributes[$videoId] as $keyField => $valueField) {
                //process single-value-columns (fillable)
                if (in_array($keyField, $svc)) {
                    //TODO it should differentiate between null and false
                    switch ($keyField){
                        case 'produced_at':
                            //validate date, I guess this was done for a strange format that what coming from youtube, but vimeo is ISO so we can store it as is
                            //TODO make helper function
                            $format = 'm-Y';
                            $d = \DateTime::createFromFormat($format, $valueField);
                            if (!$d){
                                //format is not m-Y so treat as normal date
                                $video->$keyField = $valueField;
                            } else {
                                if ($d && $d->format($format) != $valueField) throw new \Exception("Invalid Date (Produced)");
                                $video->$keyField = $d->format('Y-m-d');
                            }
                            break;
                        case 'new':
                        case 'ignore':
                            $video->$keyField = ($valueField == "1" ? true : false);
                            break;
                        default:
                            $video->$keyField = ($valueField != '' ? $valueField : null);
                            break;
                    }
                }
                //TODO enviar el id y nombre x separado!!!!
                //client
                elseif ($keyField == 'client'){
                    $client = Client::find($valueField['id']);
                    if (!$client) {
                        $client = new Client;
                        $client->name = $valueField['id'];
                        $client->save();
                    }
                    $video->client_id = $client->id;
                }
                //process multiple-value-columns
                //TODO method to get function dynamically and avoid the if?
                //metatexts
                elseif ($keyField == 'metatexts-many-count') {
                    if ($attributes[$videoId]['metatexts-many-count'] != 0)
                        $allMetatexts = $this->createAndAppendNewMetatexts(array_column($attributes[$videoId]['metatexts'], 'id'));
                    else
                        $allMetatexts = array();

                    $video->metatexts()->sync($allMetatexts);
                }
                //tags
                elseif (strpos($keyField, 'tags_') !== false) {
                    //TODO tags should we a polymorfic relation
                    $tagtype_id_requested = (int)str_replace('tags_', '', $keyField);

                    if ($keyField != 'tags_'.$tagtype_id_requested.'-many-count') {
                        $allTags = array_merge($allTags, $this->createAndAppendNewTags(array_column($valueField, 'id'), $tagtypes_objs[$tagtype_id_requested]));
                        $video->tags()->sync($allTags);
                    }
                }
            }
            $video->save();
        } catch (\Exception $e) {
            header('HTTP/1.1 500 (' . $e->getCode() . ') ' . $e->getMessage());
            header('Content-Type: application/json; charset=UTF-8');
            echo json_encode(array(
                "result" => "error",
                "message" => "An error occurred trying to save the field (" . $e->getCode() . " - " . $e->getMessage() . ")",
                "error" => $e->getMessage(),
                "code" => $e->getCode(),
            ));
            exit;
        }

        return $this->datatables_load($video->id);
    }
}
