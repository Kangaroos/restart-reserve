<?php


use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use App\FileEntry;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::group(['prefix' => '/'], function () {
    Route::resource('stores', 'StoreController');
});

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'wechat'], function () {
    Route::match(['get', 'post'], 'serve', function () {
        return 'Hello World';
    });
});

Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function() {
    Route::get('stores/{id}/classrooms', 'StoreController@getClassroomsByID');
    Route::post('stores/cover/{id}', 'StoreController@updateCover');
    Route::resource('stores', 'StoreController');

    Route::resource('classrooms', 'ClassroomController');
    Route::resource('coaches', 'CoachController');
    Route::resource('courses', 'CourseController');
});


Route::controller('admin', 'AdminController');

Route::get('file/{id}',['as' => 'getfile', function($id) {
    $entry = FileEntry::find($id);
    $file = Storage::disk('local')->get($entry->filename);
    return (new Response($file, 200))->header('Content-Type', $entry->mime);
}]);
