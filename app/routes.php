<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

/*
Route::get('/', function()
{
	return View::make('hello');
});

Route::get('/', 'HomeController@index');

*/

Route::get('/', [
        'as'    =>  'index',
        'uses'  =>  'HomeController@index'
]);

Route::get('/jobs/{id}', [
        'as'    =>  'get-job',
        'uses'  =>  'JobsController@getJob'
]);

Route::get('/appls/{id}', [
        'as'    =>  'get-appl',
        'uses'  =>  'ApplsController@getAppl'
]);

Route::post('search', function(){

	$rules = array(
		'query'         => 'required',
		'field'         => 'required',
	);

	$validator = Validator::make(Input::all(), $rules);

	if ($validator->fails()) {

		return Redirect::to('/');

	} else {

        $q = Input::get('query');
        $search = explode(' ', $q);
        $query = DB::table('jobs');

        foreach($search as $term){$query->where(Input::get('field'), 'LIKE', '%'. $term .'%');}

        $results = $query->get();

 		return View::make('jobsearch')->with('query', Input::get('query'))->with('field', Input::get('field'))->with('results', $results);

    }

});

Route::post('applyjob', function(){

	$rules = array(
		'title'         => 'required',
		'orgname'       => 'required',
		'email'         => 'required|email',
		'salary'        => 'required',
		'description'   => 'required',
	);

	$validator = Validator::make(Input::all(), $rules);

	if ($validator->fails()) {

		$messages = $validator->messages();

 	return Redirect::to('/')->withErrors($validator);

	} else {

		$jobtab = new job;
		$jobtab->title          = Input::get('title');
		$jobtab->orgname        = Input::get('orgname');
		$jobtab->email          = Input::get('email');
		$jobtab->description    = Input::get('description');
		$jobtab->salary         = Input::get('salary');

		$jobtab->save();

		return Redirect::to('/');

    }

});

Route::post('applyappl', function(){

	$rules = array(
		'firstlastname'     => 'required',
		'email'             => 'required|email',
		'notice'            => 'required',
		'education'         => 'required',
		'experience'        => 'required',
	);

	$validator = Validator::make(Input::all(), $rules);

	if ($validator->fails()) {

		$messages = $validator->messages();

 	return Redirect::to('/')->withErrors($validator);

	} else {

		$jobtab = new appl;
		$jobtab->firstlastname  = Input::get('firstlastname');
		$jobtab->email          = Input::get('email');
		$jobtab->notice         = Input::get('notice');
		$jobtab->education      = Input::get('education');
		$jobtab->experience     = Input::get('experience');

		$jobtab->save();

		return Redirect::to('/');

    }

});


