<?php

Route::redirect('/', '/admin/posts');

Route::resource('posts', 'PostsController');

Route::get('newsletter', 'NewsletterGeneratorController@index');
Route::post('newsletter', 'NewsletterGeneratorController@generate');
