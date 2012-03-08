<?php

use Laravel\Routing;

/**
* The Homepage
*/
Route::get('/', function()
{
	return View::make(Config::get('kudos.theme').'.layout')
		->nest('body', Config::get('kudos.theme').'.partials.home', array(
			'articles'=>helpers::articles(1),
			'pages'=>helpers::pages()
		)
	);
});

/**
* Handle the article URL's which are YYYY/MM/DD/Title
*/
Route::get('(:any)/(:any)/(:any)/(:any)', function($year=false,$month=false,$day=false,$article=false)
{
	if ($article && file_exists($path = Config::get('kudos.content_path')."/published/{$year}{$month}{$day}-{$article}".Config::get('kudos.markdown_extension')))
	{
		$data = article::parse($path);

		$view = View::make(Config::get('kudos.theme').'.layout')
			->with('title', helpers::unslug($article) . ' :: ')
			->nest('body', Config::get('kudos.theme').'.partials.article', $data);

		return $view;
	}
});

/**
* Drafts are not published, but if you manually enter a proper draft URL it will be rendered in the
* template so it can be previewed. ex: url.com/draft/article-title
*/
Route::get('draft/(:any)', function($article=false)
{
	if ($article && file_exists($path = Config::get('kudos.content_path')."/drafts/{$article}".Config::get('kudos.markdown_extension')))
	{
		return View::make(Config::get('kudos.theme').'.layout', array('title' => helpers::unslug($article) . ' :: '))
					->nest('body', Config::get('kudos.theme').'.partials.article', array('body'=>helpers::markdown_file($path), 'draft' => true));
	}
});

/**
* A list of all pages in the system. By default there's no navigation to this path.
*/
Route::get('page', function()
{
	return View::make(Config::get('kudos.theme').'.layout')->nest('body', Config::get('kudos.theme').'.partials.pages', array('pages'=>helpers::pages()));
});

/**
* A page, which is outside the date flow of articles. We intentially use the same
* template as articles for now
*/
Route::get('page/(:any)', function($page=false)
{
	if ($page && file_exists($path = Config::get('kudos.content_path').'/pages/'.$page.Config::get('kudos.markdown_extension')))
	{
		return View::make(Config::get('kudos.theme').'.layout', array('title' => helpers::unslug($page) . ' :: '))
					->nest('body', Config::get('kudos.theme').'.partials.article', array('body'=>helpers::markdown_file($path)));
	}
});

/**
* The archive of all articles
*/
Route::get('archive', function()
{
	return View::make(Config::get('kudos.theme').'.layout', array('title' => 'Archive :: '))
				->nest('body', Config::get('kudos.theme').'.partials.archive', array('articles'=>helpers::articles()));
});

/**
* RSS feed for articles
*/
Route::get('rss', function()
{
	return Response::make(View::make(Config::get('kudos.theme').'.rss')->with('articles', helpers::articles(20)), 200, array("Content-Type"=>"application/rss+xml"));
});

/**
* We currently cache every URI for 10 minutes. Check if a cache exists and is valid
* if it is use that.
*/
Route::filter('before', function()
{
	if (Config::get('kudos.cache'))
	{
		$key = md5(rtrim(URI::current().'-'.Input::get('page'), '-'));

		if (Cache::has($key))
		{
			return Cache::get($key);
		}
	}
});

/**
* Cache responses for 10 minutes. If you need to clear the entire cache there's a command line option for that
* in Kudos_task.php
*/
Route::filter('after', function($response)
{
	if (Config::get('kudos.cache'))
	{
		$key = md5(rtrim(URI::current().'-'.Input::get('page'), '-'));

		if ( ! Cache::has($key))
		{
			Cache::put($key, $response->content, 10);
		}
	}
});

/*
|--------------------------------------------------------------------------
| Application 404 & 500 Error Handlers
|--------------------------------------------------------------------------
|
| To centralize and simplify 404 handling, Laravel uses an awesome event
| system to retrieve the response. Feel free to modify this function to
| your tastes and the needs of your application.
|
| Similarly, we use an event to handle the display of 500 level errors
| within the application. These errors are fired when there is an
| uncaught exception thrown in the application.
|
*/

Event::listen('404', function()
{
	return Response::error('404');
});

Event::listen('500', function()
{
	return Response::error('500');
});