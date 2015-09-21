<?php

/**
* Home
*/

get('/', [
	'uses' => '\Chatty\Http\Controllers\HomeController@index',
	'as' => 'home'
]);

/**
* Auth
*/

Route::get('/signup', [
	'uses' => '\Chatty\Http\Controllers\AuthController@getSignup',
	'as' => 'auth.signup',
	'middleware' => ['guest']
]);

Route::post('/signup', [
	'uses' => '\Chatty\Http\Controllers\AuthController@postSignup',
	'middleware' => ['guest']
]);

Route::get('/signin', [
	'uses' => '\Chatty\Http\Controllers\AuthController@getSignin',
	'as' => 'auth.signin'
]);

Route::post('/signin', [
	'uses' => '\Chatty\Http\Controllers\AuthController@postSignin'
]);

Route::get('/signout', [
	'uses' => '\Chatty\Http\Controllers\AuthController@getSignout',
	'as' => 'auth.signout'
]);

/**
* Search
*/

Route::get('/search', [
	'uses' => '\Chatty\Http\Controllers\SearchController@getResults',
	'as' => 'search.results'
]);

/**
* User profile
*/

Route::get('/user/{username}', [
	'uses' => '\Chatty\Http\Controllers\ProfileController@getProfile',
	'as' => 'profile.index'
]);

Route::get('/profile/edit/', [
	'uses' => '\Chatty\Http\Controllers\ProfileController@getEdit',
	'as' => 'profile.edit',
	'middleware' => ['auth']
]);

Route::post('/profile/edit/', [
	'uses' => '\Chatty\Http\Controllers\ProfileController@postEdit',
	'middleware' => ['auth']
]);

/**
* Friends
*/

Route::get('/friends', [
	'uses' => '\Chatty\Http\Controllers\FriendController@getIndex',
	'as' => 'friend.index',
	'middleware' => ['auth']
]);

Route::get('/friends/add/{username}', [
	'uses' => '\Chatty\Http\Controllers\FriendController@getAdd',
	'as' => 'friend.add',
	'middleware' => ['auth']
]);

Route::get('/friends/accept/{username}', [
	'uses' => '\Chatty\Http\Controllers\FriendController@getAccept',
	'as' => 'friend.accept',
	'middleware' => ['auth']
]);

/**
* Statuses
*/

Route::post('/status', [
	'uses' => '\Chatty\Http\Controllers\StatusController@postStatus',
	'as' => 'status.post',
	'middleware' => ['auth']
]);

Route::post('/status/{statusId}', [
	'uses' => '\Chatty\Http\Controllers\StatusController@postReply',
	'as' => 'status.reply',
	'middleware' => ['auth']
]);

Route::get('/status/{statusId}/like', [
	'uses' => '\Chatty\Http\Controllers\StatusController@getLike',
	'as' => 'status.like',
	'middleware' => ['auth']
]);

/**
* Conversations
*/

Route::get('/conversations', [
	'uses' => '\Chatty\Http\Controllers\MessageController@getConversations',
	'as' => 'chat.list',
	'middleware' => ['auth']
]);

Route::get('/conversation/id-{id}', [
	'uses' => '\Chatty\Http\Controllers\MessageController@getChat',
	'as' => 'chat',
	'middleware' => ['auth']
]);






/*
* Socialite
*/

Route::get('/socialite/{provider}', [
        'as' => 'socialite.auth',
        function ( $provider ) {
            return \Socialite::driver( $provider )->redirect();
        }
    ]
);

Route::get('/socialite/{provider}/callback', [
	'uses' => '\Chatty\Http\Controllers\AuthController@loginGithub'
]);