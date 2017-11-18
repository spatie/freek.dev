<?php

Route::feeds();

Route::get('/', 'HomeController@index');

Route::get('/originals', 'OriginalsController@index');

Route::get('tag/{tagSlug}', 'TaggedPostsController@index');

Route::get('newsletter', 'NewsletterController@index');
Route::get('confirm-your-email', 'NewsletterController@confirm');
Route::get('subscribed', 'NewsletterController@subscribed');

Route::get('me', 'MeController@index');

Route::view('advertising', 'front.advertising.index');

Route::get('{postSlug}', 'PostsController@detail');
