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

    public function show(Playlist $playlist)
    {
    	$videos = $playlist->videos()->get();
        return view('playlists.show', compact('playlist', 'videos'));
    }
    
    public function edit(Playlist $playlist)
    {
        $videos = $playlist->videos()->get();
        return view('playlists.edit', compact('playlist','videos'));
    }

    public function update(Playlist $playlist, EditPlaylistRequest $request)
    {
        $playlist->update($request->all());
        //if video IDs are sent sync them
        if ($request->input('ids')) {
            $playlist->videos()->sync($request->input('ids'));
            $playlist->save(); //TODO needed?
//            $video_ids = $playlist->videos()->pluck('videos.id')->toArray();
//            session()->put('videos', $video_ids);
            session()->put('videos', $request->input('ids'));
        }

        if($request->ajax()){
            $content = view('playlists.modal',compact('playlist','videos'))->render();
            $panel = view('playlists.panel', ['playlist'=>$playlist->videos()->get(),'playlist_obj'=>$playlist])->render();
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
	    $videos = Video::InPlaylist()->get();
	    $playlist = Playlist::create($request->all());
        $playlist->url = "http://homestead.app/player/".$playlist->title;
        if(!$playlist->description){
            $playlist->description = 'This is a quick playlist without a description';
        }
        $playlist->save();
        $playlist->videos()->sync($videos);

        session()->put('playlist_id', $playlist->id);
        $panel = view('playlists.panel', ['playlist'=>$videos,'playlist_obj'=>$playlist])->render();

        if($request->ajax()){
            $modal = view('playlists.modal',compact('playlist'))->render();
            return response([
                        'action'       => 'create',
                        'result'       => 'playlist created',
                        'playlist'     => $videos,
                        'playlist_obj' => $playlist,
                        'content'      => $modal,
                        'panel'        => $panel
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
//            session()->push('videos.'.$video->id, 0);
            session()->push('videos',$video->id);
            $playlist = Video::InPlaylist()->get();
            $playlist_id  = session()->get('playlist_id');
            $playlist_obj = ($playlist_id ? Playlist::find($playlist_id) : null);
            $panel = view('playlists.panel', compact('playlist','playlist_obj'))->render();
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
            $playlist     = Video::InPlaylist()->get();
            $playlist_obj = ($playlist_id ? Playlist::find($playlist_id) : null);
            $panelHtml    = view('playlists.panel', compact('playlist','playlist_obj'))->render();
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
            $playlist = array();
            $playlist_obj = null;
            $panel = view('playlists.panel', compact('playlist','playlist_obj'))->render();
            return response(array('action' => 'removeall', 'result' => 'All videos removed', 'panel' => $panel)); //($content = '', $status = 200, array
        }
    }

    public function update_order(Request $request){
        session()->forget('videos');
        session()->put('videos',$request->get('order'));
        return response(array('action' => 'update_order', 'result' => 'OK'));
    }
}
