<?php

Route::feeds();

Route::get('/', 'HomeController@index');

Route::get('tag/{tagSlug}', 'TaggedPostsController@index');

Route::get('newsletter', 'NewsletterController@index');
Route::get('newsletter/confirm', 'NewsletterController@confirm');
Route::get('newsletter/subscribed', 'NewsletterController@subscribed');

Route::get('talks', 'TalksController@index');

Route::get('me', 'AboutController@index');

Route::view('advertising', 'front.advertising.index');

Route::get('{postSlug}', 'PostsController@detail');
