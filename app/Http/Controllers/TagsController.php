<?php namespace App\Http\Controllers;

use App\Tag;
use App\Tagtype;
use App\Http\Requests;
use App\Http\Requests\CreateTagRequest;
use App\Http\Requests\EditTagRequest;

class TagsController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		$tags = Tag::orderBy('value', 'asc')->with('tagtype')->get();
		$actionNew = 'TagsController@create';
		$moreButtons = 'tags._moreButtons';
		return view('tags.index', compact('tags', 'actionNew', 'moreButtons') );
	}

	public function create()
	{
		$tagtypes = Tagtype::lists('name', 'id')->toArray();
		return view('tags.create', compact('tagtypes') );
	}

	public function store(CreateTagRequest $request)
	{
		$tag = Tag::create($request->all());
		return redirect(action('TagsController@index'));
	}

	/**
	 * Show a single tag.
	 * @param  Tag  $tag 
	 * @return Response
	 */
	public function show(Tag $tag)
	{
		$tagtypes = Tagtype::lists('name', 'id')->toArray();
		return view('tags.show', compact('tag', 'tagtypes'));
	}

	public function edit(Tag $tag)
	{
		$tagtypes = Tagtype::lists('name', 'id')->toArray();
		return view('tags.edit', compact('tag', 'tagtypes'));
	}

	public function update(Tag $tag, EditTagRequest $request)
	{
		$tag->update($request->all());
		return redirect('tags');
	}

	public function destroy(Tag $tag)
	{
		$tag->delete();
		return redirect('tags');
	}
}
