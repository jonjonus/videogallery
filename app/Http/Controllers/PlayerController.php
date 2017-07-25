<?php namespace App\Http\Controllers;


use App\Playlist;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class PlayerController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function player_by_id(Playlist $playlist, Request $request)
    {
        // Authenticate
        if ($playlist->protected && empty($request->input('password'))) {
            $action = ['PlayerController@player_by_id',$playlist->id];
            return view('player.login', compact('playlist','action') );
        }
        return view('player.index_vimeo', compact('playlist') );
    }

    public function player_by_title_new($title, Request $request)
    {
        $playlist = Playlist::where('title', urldecode($title))->first();

        // Authenticate
        $alert = ($playlist->protected && Auth::check());

        if ($playlist->protected && Auth::guest()) {
            $action = ['PlayerController@player_by_title',$title];
            if (empty($request->input('password')))
                return view('player.login', compact('playlist','action','alert') );
        elseif ($request->input('password') != $playlist->password)
            return view('player.login', compact('playlist','action','alert'))->withErrors(['Invalid password']);
        }
        return view('player.vimeo.index', compact('playlist','alert') );
    }

    public function player_by_title($title, Request $request)
    {
        $playlist = Playlist::where('title', urldecode($title))->first();

        // Authenticate
        $alert = ($playlist->protected && Auth::check());

        if ($playlist->protected && Auth::guest()) {
            $action = ['PlayerController@player_by_title',$title];
            if (empty($request->input('password')))
                return view('player.login', compact('playlist','action','alert') );
        elseif ($request->input('password') != $playlist->password)
            return view('player.login', compact('playlist','action','alert'))->withErrors(['Invalid password']);
        }
        return view('player.index_vimeo', compact('playlist','alert') );
    }
}
