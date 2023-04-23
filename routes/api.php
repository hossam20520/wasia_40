<?php
use App\Http\Controllers\loginController;
use App\Http\Controllers\AdsController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\PostsController;

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:sanctum']], function () {
    // Users
    Route::post('users/media', 'UsersApiController@storeMedia')->name('users.storeMedia');
    Route::apiResource('users', 'UsersApiController');

    // Category
    Route::post('categories/media', 'CategoryApiController@storeMedia')->name('categories.storeMedia');
    Route::apiResource('categories', 'CategoryApiController');

    // Posts
    Route::post('posts/media', 'PostsApiController@storeMedia')->name('posts.storeMedia');
    Route::apiResource('posts', 'PostsApiController');

    // Ads
    Route::post('ads/media', 'AdsApiController@storeMedia')->name('ads.storeMedia');
    Route::apiResource('ads', 'AdsApiController');
});



// Route::group(['prefix' => 'v1', 'as' => 'api.', 'middleware' => ['auth:jwt']], function () {
//     // Users
//     Route::post('login', 'UsersApiController@storeMedia')->name('users.storeMedia');

// });
Route::group(['middleware' => ['jwtt']], function () {
    Route::get('/categories', [CategoriesController::class, 'categories']);
    Route::get('/categorie/{id}', [CategoriesController::class, 'GetParentscategories']);
    Route::get('/posts/cat/{id}', [PostsController::class, 'posts']);
    Route::get('/post/{id}', [PostsController::class, 'post']);
    // Route::post('/logout', [AuthController::class, 'logout']);
});



Route::get('/ads', [AdsController::class, 'ads']);
Route::post('/login', [loginController::class, 'login']);
// Route::post('/register', [AuthController::class, 'register']);