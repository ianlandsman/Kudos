<?php

/**
* The Homepage
*/
Router::register('GET /', function()
{
	return View::make('layout')->nest('body', 'partials.home', array('articles'=>helpers::articles(20), 'pages'=>helpers::pages()));
});

/**
* Handle the article URL's which are YYYY/MM/DD/Title
*/
Router::register('GET /(:any)/(:any)/(:any)/(:any)', function($year=false,$month=false,$day=false,$article=false)
{ 
	if($article && file_exists($path = Config::get('kudos.content_path')."/published/{$year}{$month}{$day}-{$article}.markdown"))
	{
		return View::make('layout', array('title' => helpers::unslug($article) . ' :: '))
					->nest('body', 'partials.article', array('body'=>helpers::markdown_file($path)));
	}

	return Response::error('404');
});

/**
* Drafts are not published, but if you manually enter a proper draft URL it will be rendered in the
* template so it can be previewed. ex: url.com/draft/article-title
*/
Router::register('GET /draft/(:any)', function($article=false)
{
	if($article && file_exists($path = Config::get('kudos.content_path')."/drafts/{$article}.markdown"))
	{
		return View::make('layout', array('title' => helpers::unslug($article) . ' :: '))
					->nest('body', 'partials.article', array('body'=>helpers::markdown_file($path),'draft' => true));	
	}

	return Response::error('404');
});

/**
* A list of all pages in the system. By default there's no navigation to this path.
*/
Router::register('GET /page', function()
{
	return View::make('layout')->nest('body', 'partials.pages', array('pages'=>helpers::pages()));
});

/**
* A page, which is outside the date flow of articles. We intentially use the same
* template as articles for now
*/
Router::register('GET /page/(:any)', function($page=false)
{
	if($page && file_exists($path = Config::get('kudos.content_path').'/pages/'.$page.'.markdown'))
	{
		return View::make('layout', array('title' => helpers::unslug($page) . ' :: '))
					->nest('body', 'partials.article', array('body'=>helpers::markdown_file($path)));		
	}	

	return Response::error('404');
});

/**
* The archive of all articles
*/
Router::register('GET /archive', function()
{
	return View::make('layout', array('title' => 'Archive :: '))
				->nest('body', 'partials.archive', array('articles'=>helpers::articles()));					
});

/**
* RSS feed for articles
*/
Router::register('GET /rss', function()
{
	return View::make('rss')->with('articles', helpers::articles(20));
});

/**
* We currently cache every URI for 10 minutes. Check if a cache exists and is valid
* if it is use that.
*/
Filter::register('before', function()
{
	$key = md5(URI::current());

	if(Cache::has($key)) 
	{
		return Cache::get($key);
	}
});

/**
* Cache responses for 10 minutes. If you need to clear the entire cache there's a command line option for that
* in Kudos_task.php
*/
Filter::register('after', function($response)
{
	Cache::put(md5(URI::current()), $response->content, 10);
});