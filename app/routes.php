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

Route::get('/', function()
{
	return Redirect::to('search');
});


if (Input::get('q')){
    Route::match(array('GET', 'POST'), 'search', array('as' => 'searchResults', 'uses' => 'SearchController@showResults'));
} else {
    Route::match(array('GET', 'POST'), 'search', array('as' => 'searchForm', 'uses' => 'SearchController@showSearchForm'));
}

Route::get('record/{id}', array('as' => 'fullRecord', 'uses' => 'RecordController@getByID'));