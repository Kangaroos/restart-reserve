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

Route::get('/', ['uses' => 'StoreController@index']);

Route::group(['namespace' => 'Auth', 'prefix' => '/auth'], function () {
    Route::get('/login', 'AuthController@getLogin');
    Route::post('/login', ['as' => 'login', 'uses' => 'AuthController@postLogin']);
    Route::get('/logout', ['as' => 'logout', 'uses' => 'AuthController@getLogout']);
});

Route::group(['prefix' => '/'], function () {
    Route::resource('stores', 'StoreController');
    Route::get('stores/{id}/courses', ['as' => 'store.courses', 'uses' => 'CourseController@getCoursesByStoreId']);
    Route::get('courses/{id}/reserve', ['as' => 'course.reserve', 'uses' => 'CourseController@getCourseReserveById']);
    Route::get('courses/{id}/reserve/result', ['as' => 'course.reserve.result', 'uses' => 'CourseController@getCourseReserveResultById']);
    Route::resource('courses', 'CourseController');
});

Route::group(['prefix' => '/members', 'middleware' => ['auth', 'acl'], 'is' => 'member'], function () {
    Route::get('', ['as' => 'members', 'uses' => 'UserController@getMembers']);
    Route::get('reserve/', ['uses' => 'UserController@getMembersReserve']);
    Route::get('reserve/{id}', ['uses' => 'UserController@getMembersReserveDetail']);
});

Route::group(['prefix' => 'wechat'], function () {
    Route::match(['get', 'post'], 'serve', ['uses' => 'WechatController@serve']);
    Route::get('callback', ['as' => 'wechat.callback', 'uses' => 'WechatController@callback']);
});

Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['admin.auth', 'acl'], 'is' => 'administrator'], function() {
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
