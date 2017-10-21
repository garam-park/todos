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

Route::get('todos',function()
{
	return App\Todo::paginate();
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