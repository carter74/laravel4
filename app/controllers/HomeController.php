<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function index()
	{
        $jobs   = job::get();
        $appls  = appl::get();

//        print_r($jobs); echo "<hr>";
//        print_r($appls); echo "<hr>";

		return View::make('index')->with('jobs', $jobs)->with('appls', $appls);

	}

}
