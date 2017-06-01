<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Metatext;
use App\Http\Requests;
use App\Http\Requests\CreateMetatextRequest;
use App\Http\Requests\EditMetatextRequest;

class MetatextsController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		$metatexts = Metatext::orderBy('name', 'asc')->get();
        $actionNew = 'MetatextsController@create';
        $moreButtons = 'metatexts._moreButtons';
        return view('metatexts.index', compact('metatexts',
                                               'actionNew',
                                               'moreButtons'));
	}

	public function create()
	{
		return view('metatexts.create');
	}

	public function store(CreateMetatextRequest $request)
	{	
		$metatext = Metatext::create($request->all());
		return redirect(action('MetatextsController@index'));
	}

	/**
	 * Show a single metatext.
	 * @param  Metatext  $metatext 
	 * @return Response
	 */
	public function show(Metatext $metatext)
	{
		return view('metatexts.show', compact('metatext'));
	}

	public function edit(Metatext $metatext)
	{
		return view('metatexts.edit', compact('metatext'));
	}

	public function update(Metatext $metatext, EditMetatextRequest $request)
	{
		$metatext->update($request->all());
		return redirect('metatexts');
	}

	public function destroy(Metatext $metatext)
	{
		$metatext->delete();
		return redirect('metatexts');
	}
}
