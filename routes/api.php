<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('todos',function(Request $request)
{

	$only = $request->only(['title','desc']);

	$validator = Validator::make($only, [
		'title'	=> 'required|string',
		'desc'	=> 'string',
	]);

	if ($validator->fails()) {
		return response()
			->json(['message' => $validator->errors()],400);
	}

	return App\Todo::create($only);
});

Route::get('todos',function()
{
	return App\Todo::paginate();
});

Route::get('todos/{id}',function($id)
{
	$todo = App\Todo::find($id);
	if(!$todo){
		return response()
		->json(['message' => "Not Found"],404);
	}
	return $todo;
});

Route::delete('todos/{id}',function($id)
{
	$todo = App\Todo::find($id);
	if(!$todo){
		return response()
		->json(['message' => "Not Found"],404);
	}

	$todo->delete();
	return $todo;
});

Route::put('todos/{id}',function(Request $request,$id)
{
	$only = $request->only(['title','desc']);

	$validator = Validator::make($only, [
		'title'	=> 'required|string',
		'desc'	=> 'string',
	]);

	if ($validator->fails()) {
		return response()
			->json(['message' => $validator->errors()],400);
	}

	$todo = App\Todo::find($id);
	
	if(!$todo){
		return response()
		->json(['message' => "Not Found"],404);
	}

	foreach ($only as $key => $value) {
		$todo->$key = $value;
	}
	$todo->save();

	return $todo;
});