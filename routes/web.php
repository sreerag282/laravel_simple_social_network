<?php


// use Symfony\Component\Routing\Annotation\Route;

// use Illuminate\Routing\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::get('/register', 'UserController@registerview')->name('register');
Route::get('/login', 'UserController@loginview')->name('login');
Route::post('/register', [
    'uses'=>'UserController@register_user',
    'as' => 'postregister']
);
Route::post('/login_check','UserController@login_user');
Route::get('/logout','UserController@logout');
Route::get('/dashboard', 'UserController@sucessLogin')->name('dashboard');
Route::POST('/createpost', 'Postcontroller@createPost');
Route::get('/deletepost/{post_id}', [
    'uses'=>'Postcontroller@deletepost',
    'as' => 'deletepost']
);
Route::post('/edit',[
    'uses' => 'Postcontroller@postEdit',
    'as' => 'edit'
]
);
Route::get('/user_profile',[
    'uses' => 'UserController@showprofilepage',
    'as' => 'user_profile'
])->middleware('auth');

Route::post('/user_profile_save','UserController@save_user_profile')->name('user_profile_save');
// Route::get('/user_image/{file_name}','UserController@get_user_image')->name('user_image');
Route::post('/like','Postcontroller@likeAction')->name('like');

