<?php

class TagsController extends \BaseController {


	public function __construct()
	{
		$this->beforeFilter('auth', array('only' => array('create', 'store', 'edit', 'update', 'destroy')));
		$this->beforeFilter('csrf', array('only' => array('store', 'update', 'destroy')));
	}

	/**
	 * Display a listing of the resource.
	 * GET /tags
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('tags.list')->with('tags', Tag::where('count', '>', '0')->orderBy('count', 'desc')->orderBy('updated_at', 'desc')->get());
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /tags/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /tags
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /tags/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /tags/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		return View::make('tags.edit')->with('tag', Tag::find($id));
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /tags/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$rules = array(
			'name' => array('required', 'regex:/^\w+$/'),
		);
		$validator = Validator::make(Input::only('name'), $rules);
		if ($validator->passes()) {
			Tag::find($id)->update(Input::only('name'));
			return Redirect::back()->with('message', array('type' => 'success', 'content' => 'Modify tag successfully'));
		} else {
			return Redirect::back()->withInput()->withErrors($validator);
		}
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /tags/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$tag = Tag::find($id);
		$tag->count = 0;
		$tag->save();
		foreach ($tag->articles as $article) {
			$tag->articles()->detach($article->id);
		}
		return Redirect::back();
	}

	public function articles($id)
	{
		$tag = Tag::find($id);
		$articles = $tag->articles()->orderBy('created_at', 'desc')->paginate(10);
		return View::make('articles.specificTag')->with('tag', $tag)->with('articles', $articles);
	}

}