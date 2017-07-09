<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;	
use Illuminate\Http\Response;

use App\Video;
use App\Playlist;
use App\Http\Requests;
// use App\Http\Requests\Request;
use App\Http\Requests\CreatePlaylistRequest;
use App\Http\Requests\EditPlaylistRequest;
use App\Http\Requests\AddToPlaylistRequest;
use App\Http\Requests\RemoveFromPlaylistRequest;
use Zend\Stdlib\PriorityList;

class PlaylistsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /* REST */

    public function index()
    {
        $playlists   = Playlist::paginate(10);
        $actionNew   = 'PlaylistsController@create';
        $moreButtons = 'playlists._moreButtons';
        return view('playlists.index', compact ('playlists', 'actionNew', 'moreButtons') );
    }

    public function create()
    {
        $videos = Video::InPlaylist()->get();
        return view('playlists.create', compact('videos'));
    }

    public function show(Playlist $playlist_videos)
    {
    	$videos = $playlist_videos->videos()->orderBy('order')->get();
        return view('playlists.show', compact('playlist_videos', 'videos'));
    }
    
    public function edit(Playlist $playlist_videos)
    {
        $videos = $playlist_videos->videos()->orderBy('order')->get();
        return view('playlists.edit', compact('playlist_videos','videos'));
    }

    public function update(Playlist $playlist, EditPlaylistRequest $request)
    {
        $playlist->update($request->all());
        //if video IDs are sent sync them
        if ($request->input('ids')) {
            $playlist->videos()->sync([]);
            $playlist->videos()->sync($request->input('ids'));
            session()->put('videos', $request->input('ids'));
        }
        // TODO separate the buttons create and save
        if($request->ajax()){
            $content = view('playlists.modal',compact('playlist'))->render();
            $panel = view('playlists.panel', ['playlist_videos'=>$playlist->videos()->orderBy('order')->get(),'playlist_obj'=>$playlist])->render();
            return response([
                'action'       => 'update',
                'result'       => 'playlist updated',
                'playlist'     => $request->input('ids'),
                'playlist_obj' => $playlist,
                'content'      => $content,
                'panel'        => $panel
            ]);

        }
        return redirect('playlists');
    }

    public function store(CreatePlaylistRequest $request)
    {
        $session_video_ids = session()->get('videos');
        //TODO cada vez que llamo a Video::InPlaylist()->get() deberia estar encapsulado con en una fucnion que lo odene como corresponde segun el orden de la session
	    $videos = Video::InPlaylist()->get();
        // we get the video objects for those IDs in the playlist (session) but it might not be ordered the same way,
        // how it was dragged and dropped, it comes how it is ordered in the DB.
        //so we need to re order it to match the playlist
        $videos = $videos->sort(function ($a, $b) use ($session_video_ids) {
            $pos_a = array_search($a->id, $session_video_ids);
            $pos_b = array_search($b->id, $session_video_ids);
            return $pos_a - $pos_b;
        });

	    $playlist = Playlist::create($request->all());
        $playlist->url = "http://homestead.app/player/".$playlist->title;
        $playlist->save();
        $playlist->videos()->sync($videos);

        session()->put('playlist_id', $playlist->id);
        $panel = view('playlists.panel', ['playlist_videos'=>$videos,'playlist_obj'=>$playlist])->render();

        if($request->ajax()){
            $modal = view('playlists.modal',compact('playlist'))->render();
            return response([
                        'action'          => 'create',
                        'result'          => 'playlist created',
                        'playlist_videos' => $videos,
                        'playlist_obj'    => $playlist,
                        'content'         => $modal,
                        'panel'           => $panel
                    ]);
        }
        return redirect(action('PlaylistsController@index'));
    }

    public function destroy(Playlist $playlist)
    {
        $playlist->delete();
        return redirect('playlists');
    }

    /* CUSTOM */
    public function load(Request $request){
        $playlist = Playlist::find($request->input('playlist_id'));
        //check if there are videos selected
        if (count(session()->get('videos')) && $request->input('confirm') != 'yes'){
            $message = (session()->get('playlist_id') ? 'You are editing another playlist, if you continue the changes will be lost.' : 'There are videos loaded, if you continue laoding the playlist they will be lost.');
            //TODO make the message dismissable instead of reloading the page
            $href = action('PlaylistsController@index');
            return redirect('playlists')->with('info',array(
                'message' => $message,
                'options' => array(
                    "<a class='btn btn-sm btn-info' href='{{ $href }}' role='button'>Cancel</a>",
                    view('Playlists.form-load-confirm',['playlist_id' => $playlist->id])->render()
                )
            ));
        }
        //load playlist
        $video_ids = $playlist->videos()->pluck('videos.id')->toArray();
        session()->put('videos', $video_ids);
        session()->put('playlist_id',$playlist->id);
        return redirect('videos'); //->with('playlist_id', $playlist->id);

    }

    //TODO check here if we're handling the playlist id coorectly?

    public function add(Video $video)
    {
        $videos = session()->get('videos');
        if ( count($videos) && in_array($video->id, $videos) ){
            header('HTTP/1.1 500 The video is already in the playlist');
            header('Content-Type: application/json; charset=UTF-8');
            echo json_encode( array("result" => 'The video is already in the playlist') );
            exit;
        } else {
            session()->push('videos',$video->id);
            $videos[] = $video->id; //also need to add it to this array as it was already loaded from the session before

            $playlist_videos = Video::InPlaylist()->get();
            $playlist_id  = session()->get('playlist_id');
            $playlist_obj = ($playlist_id ? Playlist::find($playlist_id) : null); //TODO find no devuelve nul anyway?

            // we get the video objects for those IDs in the playlist (session) but it might not be ordered the same way,
            // how it was dragged and dropped, it comes how it is ordered in the DB.
            //so we need to re order it to match the playlist
            $playlist_videos = $playlist_videos->sort(function ($a, $b) use ($videos) {
                $pos_a = array_search($a->id, $videos);
                $pos_b = array_search($b->id, $videos);
                return $pos_a - $pos_b;
            });

            $panel = view('playlists.panel', compact('playlist_videos','playlist_obj'))->render();
            return response(array('action' => 'add', 'result' => 'Video added', 'panel' => $panel)); //($content = '', $status = 200, array $headers = [])
        }
        // return redirect(action('VideosController@index'));       
    }

    public function remove(Video $video)
    {
        $videos      = session()->get('videos');
        $playlist_id = session()->get('playlist_id');

        $key=array_search($video->id, $videos);

        if (!count($videos) || $key===false ){
            header('HTTP/1.1 500 The video was not found in the playlist');
            header('Content-Type: application/json; charset=UTF-8');
            echo json_encode(array('action' => 'remov', 'result' => 'The video was not found in the playlist') );
            exit;
        } else {
            unset($videos[$key]);
//            session(['videos' => $videos]);
            session()->put('videos', $videos);
            //get the videos in the the current playlist
            $playlist_videos     = Video::InPlaylist()->get();
            $playlist_obj = ($playlist_id ? Playlist::find($playlist_id) : null);
            $panelHtml    = view('playlists.panel', compact('playlist_videos','playlist_obj'))->render();
            return response(array('action' => 'remove', 'result' => 'Video removed', 'panel' => $panelHtml)); //($content = '', $status = 200, array $headers = [])
        }
    }

    public function removeall(){
    	$videos = session()->get('videos');
    	if (!count($videos)){
    		header('HTTP/1.1 500 The playlist is already empty');
        	header('Content-Type: application/json; charset=UTF-8');
        	echo json_encode(array('action' => 'removeall', 'result' => 'The playlist is already empty'));
        	exit;
        } else {
	    	session()->forget('videos');
	    	session()->forget('playlist_id');
            $playlist_videos = array();
            $playlist_obj = null;
            $panel = view('playlists.panel', compact('playlist_videos','playlist_obj'))->render();
            return response(array('action' => 'removeall', 'result' => 'All videos removed', 'panel' => $panel)); //($content = '', $status = 200, array
        }
    }

    public function update_order(Request $request){
        session()->forget('videos');
        session()->put('videos',$request->get('order'));
        return response(array('action' => 'update_order', 'result' => 'OK'));
    }
}
