<?php namespace App\Http\Controllers;

use App\Tagtype;
use App\Http\Requests;
use App\Http\Requests\CreateTagtypeRequest;
use App\Http\Requests\EditTagtypeRequest;

class TagtypesController extends Controller
{
      public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		$tagtypes = Tagtype::orderBy('name', 'asc')->get();
		$actionNew = 'TagtypesController@create';
		$moreButtons = 'tags._moreButtons';
		return view('tagtypes.index', compact('tagtypes', 'actionNew', 'moreButtons') );
	}

	public function create()
	{
		return view('tagtypes.create');
	}

	public function store(CreateTagtypeRequest $request)
	{
		$tagtype = Tagtype::create($request->all());
		return redirect(action('TagtypesController@index'));
	}

	/**
	 * Show a single tag type.
	 * @param  Tagtype  $tagtype
	 * @return Response
	 */
	public function show(Tagtype $tagtype)
	{
		return view('tagtypes.show', compact('tagtype'));
	}

	public function edit(Tagtype $tagtype)
	{
		return view('tagtypes.edit', compact('tagtype'));
	}

	public function update(Tagtype $tagtype, EditTagtypeRequest $request)
	{
		$tagtype->update($request->all());
		return redirect('tagtypes');
	}

	public function destroy(Tagtype $tagtype)
	{
		$tagtype->delete();
		return redirect('tagstypes');
	}
}
