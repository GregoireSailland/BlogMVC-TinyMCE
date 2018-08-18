<?php

$slugPattern = '[a-z0-9\-]+';

Route::group(['prefix'=>'salut'], function(){
		Route::get('/',['as' => 'salut',
			function(){
				return 'Salut! Quel est ton nom?';
			}
		]);
		Route::get('/{slug}-{id}',['as' => 'salut',
			function($slug, $id){
				return "Lien : " . 
				route('salut',['slug' => $slug,'id' => $id]);
			}
		])->where('slug', '[a-z0-9\-]+')->where('id','[0-9]+');

		Route::get('/{slug}',['as' => 'salut',
			function($slug){
				return "Lien : " . 
				route('salut',['slug' => $slug]);
			}
		])->where('slug', '[a-z0-9\-]+');



	}
);
/*
Route::get('salut',['as' => 'salut',
	function(){
		return 'Salut! Quel est ton nom?';
	}
]);


Route::get('salut/{slug}-{id}',['as' => 'salut',
	function($slug, $id){
		return "Lien : " . 
		route('salut',['slug' => $slug,'id' => $id]);
	}
])->where('slug', '[a-z0-9\-]+')->where('id','[0-9]+');

Route::get('salut/{slug}',['as' => 'salut',
	function($slug){
		return "Lien : " . 
		route('salut',['slug' => $slug]);
	}
])->where('slug', '[a-z0-9\-]+');
*/

// We want to use specific routes (not the full authentication
Route::group(['namespace' => 'Auth'], function () {
    Route::get('/login', 'LoginController@showLoginForm')->name('login');
    Route::post('/login', 'LoginController@login');
    Route::post('/logout', 'LoginController@logout')->name('logout');
});
// Auth::routes();
Route::get('/', 'PostController@index')->name('home');
Route::get('/posts/{slug}', 'PostController@show')->name('posts.show')->where('slug', $slugPattern);
Route::get('/category/{slug}', 'PostController@category')->name('posts.category')->where('slug', $slugPattern);
Route::get('/user/{id}', 'PostController@user')->name('posts.user')->where('id', '[0-9]+');

Route::resource('comments', 'CommentController', ['only' => ['store']]);

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'as' => 'admin.', 'middleware' => 'auth'], function () {
    Route::resource('posts', 'PostController'
    	/**///,['except'=>['edit']]
	);
	/**///Route::get('/poss/{post}/edit','PostController@edit')->middleware('can:update-post',post);
});


/*Route::group(['middleware' => 'auth'], function () {
    Route::get('/laravel-filemanager', '\UniSharp\LaravelFilemanager\controllers\LfmController@show');
    Route::post('/laravel-filemanager/upload', '\UniSharp\LaravelFilemanager\controllers\UploadController@upload');
    // list all lfm routes here...
});*/