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

/** ------------------------------------------
 *  Interface repository binding
 *  ------------------------------------------
 */
App::bind('UserRepositoryInterface', 'EloquentUserRepository');
App::bind('PostRepositoryInterface', 'EloquentPostRepository');
App::bind('CommentRepositoryInterface', 'EloquentCommentRepository');

/** ------------------------------------------
 *  Route model binding
 *  ------------------------------------------
 */
Route::model('comment', 'Comment');
Route::model('post', 'Post');
Route::model('role', 'Role');

/** ------------------------------------------
 *  Admin Routes
 *  ------------------------------------------
 */
Route::group(array('prefix' => 'admin', 'before' => 'auth'), function()
{

    # Comment Management
    // Route::get('comments/{comment}/edit', 'AdminCommentsController@getEdit')
    //     ->where('comment', '[0-9]+');
    // Route::post('comments/{comment}/edit', 'AdminCommentsController@postEdit')
    //     ->where('comment', '[0-9]+');
    // Route::get('comments/{comment}/delete', 'AdminCommentsController@getDelete')
    //     ->where('comment', '[0-9]+');
    // Route::post('comments/{comment}/delete', 'AdminCommentsController@postDelete')
    //     ->where('comment', '[0-9]+');
    // Route::controller('comments', 'AdminCommentsController');
    Route::get('comments/data', 'AdminCommentsController@data'); // Outputs Datatables json
    Route::resource('comments', 'AdminCommentsController',
                array('except' => array('create', 'store')));

    # Posts Management
    Route::get('posts/data', 'AdminPostsController@data'); // Outputs Datatables json
    Route::resource('posts', 'AdminPostsController');

    # Users Management
    Route::get('users/data', 'AdminUsersController@data'); // Outputs Datatables json
    Route::resource('users', 'AdminUsersController');

    # User Role Management
    Route::get('roles/{role}/show', 'AdminRolesController@getShow')
        ->where('role', '[0-9]+');
    Route::get('roles/{role}/edit', 'AdminRolesController@getEdit')
        ->where('role', '[0-9]+');
    Route::post('roles/{role}/edit', 'AdminRolesController@postEdit')
        ->where('role', '[0-9]+');
    Route::get('roles/{role}/delete', 'AdminRolesController@getDelete')
        ->where('role', '[0-9]+');
    Route::post('roles/{role}/delete', 'AdminRolesController@postDelete')
        ->where('role', '[0-9]+');
    Route::controller('roles', 'AdminRolesController');

    # Admin Dashboard
    Route::controller('/', 'AdminDashboardController');
});


/** ------------------------------------------
 *  Frontend Routes
 *  ------------------------------------------
 */

// User reset routes
Route::get('user/reset/{token}', 'UserController@getReset')
    ->where('token', '[0-9a-z]+');
// User password reset
Route::post('user/reset/{token}', 'UserController@postReset')
    ->where('token', '[0-9a-z]+');
//:: User Account Routes ::
Route::post('user/{user}/edit', 'UserController@postEdit')
    ->where('user', '[0-9]+');

//:: User Account Routes ::
Route::post('user/login', 'UserController@postLogin');

# User RESTful Routes (Login, Logout, Register, etc)
Route::controller('user', 'UserController');

//:: Application Routes ::

# Contact Us Static Page
Route::get('contact-us', function()
{
    // Return about us page
    return View::make('site/contact-us');
});

# Posts - Second to last set, match slug
Route::get('{postSlug}', 'BlogController@getView');
Route::post('{postSlug}', 'BlogController@postView');

# Index Page - Last route, no matches
Route::get('/', 'BlogController@getIndex');
