<?php

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

Route::get('/', function () {
    return view('index');
});

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');
Route::get('auth/register', [
    'as' => 'genres',
    'uses' => 'Auth\AuthController@displayForm'
]);

Route::get('login/{provider?}', 'Auth\AuthController@SocialLogin');

// Your profile routes and router for your profile settings
Route::get('profile/settings', ['as' => 'profile-settings', 'uses' => 'User\UserController@showProfileSettings']);
Route::post('profile/settings', ['as' => 'user_updateData', 'uses' => 'User\UserController@postUpdateData']);

Route::get('profile/{id}', ['as' => 'profile', 'uses' => 'User\UserController@show']);
Route::post('profile/{id}', ['as' => 'profile', 'uses' => 'User\UserController@follow']);

Route::get('/status/{slug}', 'User\UserController@showStatus');
Route::post('/status/{slug}', 'User\UserController@storeStatus');


Route::get('/faq', function () {
    return view('faq.faq');
});

Route::get('/contact', function () {
    return view('contact.contact');
});

Route::get('/services', 'ServiceController@index');
Route::get('/service/{slug}', 'ServiceController@serviceIndex');
Route::get('/service/comment/{id}', 'ServiceController@serviceRateIndex');
Route::post('/service/comment/{id}', ['as' => 'comment_service', 'uses' => 'ServiceController@serviceRate']);

Route::group(['prefix' => 'messages', 'middleware' => ['auth']], function () {
    Route::get('/', ['as' => 'messages', 'uses' => 'User\MessageController@index']);
    Route::get('/getUsers', 'User\MessageController@getUsers');
    Route::get('create', ['as' => 'messages.create', 'uses' => 'User\MessageController@create']);
    Route::get('create/{slug}', ['as' => 'messages.create', 'uses' => 'User\MessageController@create2']);
    Route::post('/', ['as' => 'messages.store', 'uses' => 'User\MessageController@store']);
    Route::get('{id}', ['as' => 'messages.show', 'uses' => 'User\MessageController@show']);
    Route::put('{id}', ['as' => 'messages.update', 'uses' => 'User\MessageController@update']);
});


//Album routes...
Route::get('profile/{id}/album', array('as' => 'album', 'uses' => 'AlbumsController@getList'));
Route::get('profile/{id}/createAlbum', array('as' => 'create_album_form', 'uses' => 'AlbumsController@getForm'));
Route::post('profile/{id}/createAlbum', array('as' => 'createAlbum', 'uses' => 'AlbumsController@postCreate'));
Route::get('profile/{id}/deleteAlbum/{idAlbum}', array('as' => 'delete_album', 'uses' => 'AlbumsController@getDelete'));
Route::get('profile/{id}/album-show/{idAlbum}', array('as' => 'show_album', 'uses' => 'AlbumsController@getAlbum'));

Route::get('profile/{id}/addImage/{idAlbum}', array('as' => 'add_image', 'uses' => 'ImagesController@getForm'));
Route::post('profile/{id}/addImage/{idAlbum}', array('as' => 'add_image_to_album', 'uses' => 'ImagesController@postAdd'));
Route::get('profile/{id}/deleteImage/{idImage}', array('as' => 'delete_image', 'uses' => 'ImagesController@getDelete'));
Route::post('profile/{id}/moveImage', array('as' => 'move_image', 'uses' => 'ImagesController@postMove'));

//Music album routes
Route::get('profile/{id}/music', array('as' => 'music', 'middleware' => ['role:artist'], 'uses' => 'MusicController@index'));
Route::get('profile/{id}/music/add-song', array('as' => 'add_song', 'uses' => 'MusicController@create'));
Route::post('profile/{id}/music/add-song', array('as' => 'store_song', 'uses' => 'MusicController@store'));
Route::get('profile/{id}/delete-song/{idSong}', array('as' => 'delete_song', 'uses' => 'MusicController@destroy'));

Route::get('event', array('as' => 'event', 'middleware' => ['auth', 'role:artist|Venue'], 'uses' => 'EventController@index'));
Route::post('event', array('as' => 'event', 'middleware' => ['auth', 'role:artist|Venue'], 'uses' => 'EventController@store'));
Route::get('event/{slug}', array('as' => 'show_event', 'uses' => 'EventController@show'));
Route::post('event/{slug}', array('as' => 'event_users', 'uses' => 'EventController@userEventStatus'));
Route::get('getVenues', 'EventController@getVenues');
Route::get('getArtists', 'EventController@getArtists');

//Ratings routes TODO:doradi rute za raitings
Route::post('/ratings', array('as' => 'store_ratings_song', 'uses' => 'RatingsSongsController@store'));
Route::get('/ratings', array('as' => 'ratings_value', 'uses' => 'RatingsSongsController@ratingsValue'));
Route::get('/ratings/song', array('as' => 'song_info', 'uses' => 'RatingsSongsController@songInfo'));

// Add this route for checkout or submit form to pass the item into paypal
Route::post('payment', array('as' => 'payment', 'uses' => 'PayPalController@postPayment'));

// After the payment is made, PayPal redirects the user back to our site
Route::get('payment/status', array('as' => 'payment.status', 'uses' => 'PayPalController@getPaymentStatus'));

// after the payment is done (successfully or not) the user gets redirected here
Route::get('payment', function () {
    return view('payment');
});

Route::group(['prefix' => 'staffcp', 'middleware' => ['auth', 'role:admin|mod']], function () {
    Route::get('/', array('as' => 'staffcp', 'uses' => 'StaffCPController@index'));
    Route::get('service_requests', array('as' => 'service_requests', 'uses' => 'StaffCPController@service_requests'));
    Route::get('service_requests/{user_id}/{service_id}', array('as' => 'service_requests', 'uses' => 'StaffCPController@Approving_service_requests'));
});

//Testing
Route::get('/testing', array('as' => 'testing', 'uses' => 'TestingController@index'));
Route::post('/testing', array('as' => 'testing', 'uses' => 'TestingController@store'));