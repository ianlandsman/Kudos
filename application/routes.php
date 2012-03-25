<?php

use Laravel\Routing;

/**
* The Homepage
*/
Route::get('/', function()
{
	return View::make(Config::get('kudos.theme').'.partials.home')
		->with('description', '')
		->with('keywords', '')
		->with('articles', article::get(10))
		->with('categories', article::categories())
		->with('pages', helpers::pages());
});

/**
* Handle the article URL's which are YYYY/MM/DD/Title
*/
Route::get('(:any)/(:any)/(:any)/(:any)', function($year=false,$month=false,$day=false,$article=false)
{
	if ($article && file_exists($path = Config::get('kudos.content_path')."/published/{$year}{$month}{$day}-{$article}".Config::get('kudos.markdown_extension')))
	{
		$data = article::parse($path);

		$description = (isset($data['description'])) ? $data['description'] : '';
		$keywords = (isset($data['keywords'])) ? $data['keywords'] : '';

		$data['article'] = $data;
		$view = View::make(Config::get('kudos.theme').'.partials.article')
			->with('title', $data['title'] . ' :: ')
			->with('description', $description)
			->with('keywords', $keywords)
			->with($data);

		return $view;
	}
	return Response::error('404');
});

/**
* Category
*/
Route::get('category/(:any)', function($cat = null)
{
	return View::make(Config::get('kudos.theme').'.partials.home')
		->with('description', '')
		->with('keywords', '')
		->with('articles', article::search('category', $cat))
		->with('category', $cat)
		->with('pages', helpers::pages());
});

/**
* Drafts are not published, but if you manually enter a proper draft URL it will be rendered in the
* template so it can be previewed. ex: url.com/draft/article-title
*/
Route::get('draft/(:any)', function($article=false)
{
	if ($article && file_exists($path = Config::get('kudos.content_path')."/drafts/{$article}".Config::get('kudos.markdown_extension')))
	{
		return View::make(Config::get('kudos.theme').'.partials.article')
			->with('description', '')
			->with('keywords', '')
			->with('title', helpers::unslug($article) . ' :: ')
			->with('body', helpers::markdown_file($path))
			->with('draft', true);
	}
	return Response::error('404');
});

/**
* A list of all pages in the system. By default there's no navigation to this path.
*/
Route::get('page', function()
{
	return View::make(Config::get('kudos.theme').'.partials.pages')
		->with('pages', helpers::pages());
});

/**
* A page, which is outside the date flow of articles. We intentially use the same
* template as articles for now
*/
Route::get('page/(:any)', function($page=false)
{
	if ($page && file_exists($path = Config::get('kudos.content_path').'/pages/'.$page.Config::get('kudos.markdown_extension')))
	{
		return View::make(Config::get('kudos.theme').'.partials.article')
			->with('title', helpers::unslug($page) . ' :: ')
			->with('keywords', '')
			->with('description', '')
			->with('body', helpers::markdown_file($path));
	}
	return Response::error('404');
});

/**
* The archive of all articles
*/
Route::get('archive', function()
{
	return View::make(Config::get('kudos.theme').'.partials.archive')
		->with('title', 'Archive :: ')
		->with('description', '')
		->with('keywords', '')
		->with('articles', article::get(50));
});

/**
* RSS feed for articles
*/
Route::get('rss', function()
{
	return Response::make(
		View::make(Config::get('kudos.theme').'.rss')
		->with('articles', article::get(20)), 200,
		array("Content-Type"=>"application/rss+xml"));
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