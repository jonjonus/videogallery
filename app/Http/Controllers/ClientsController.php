<?php namespace App\Http\Controllers;

use App\Client;
use App\Video;
use App\Http\Requests;
use App\Http\Requests\CreateClientRequest;
use App\Http\Requests\EditClientRequest;

class ClientsController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}
	
	public function index()
	{
		$clients = Client::orderBy('name', 'asc')->get();

		$actionNew = 'ClientsController@create';
		$moreButtons = 'tags._moreButtons';
//		$playlist = Video::InPlaylist()->get();

		return view('clients.index', compact('clients',
                                             'actionNew',
                                             'moreButtons') );
	}

	public function create()
	{
		return view('clients.create');
	}

	public function store(CreateClientRequest $request)
	{
		Client::create($request->all());
		return redirect(action('ClientsController@index'));
	}

	public function show(Client $client)
	{
		return view('clients.show', compact('client'));
	}

	public function edit(Client $client)
	{
		return view('clients.edit', compact('client'));
	}

	public function update(Client $client, EditClientRequest $request)
	{
		$client->update($request->all());
		return redirect('clients');
	}

	public function destroy(Client $client)
	{
		$client->delete();
		return redirect('clients');
	}

	public function videos($id)
	{
		$client = Client::findOrFail($id);
		$videos = $client->videos;
		return view('videos.index', compact('videos'));
	}
}
