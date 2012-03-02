<?php defined('DS') or die('No direct script access.');


class helpers {

	public static function unslug($text)
	{
		return str_replace('-', ' ', $text);
	}

	public static function markdown_file($file)
	{
		return static::markdown(static::restricted_file_get_contents($file));
	}

	public static function markdown($string)
	{
		require_once(path('app').'/libraries/markdown.php');

		return static::clean(markdown($string));
	}

	public static function restricted_file_get_contents($file)
	{
		if (strpos(realpath($file), Config::get('kudos.content_path')) !== false)
		{
			return file_get_contents($file);
		}
		else
		{
			return '';
		}
	}

	public static function articles($count = '*')
	{
		// Get all the articles
		$articles = glob(Config::get('kudos.content_path')."/published/*.markdown");

		if ($articles)
		{
			// Sort them newest to oldest
			rsort($articles);

			// Are we limiting? If not let's just give them a bunch
			if ($count == '*') return Paginator::make($articles, count($articles), 100);

			// bug in paging?
			$sliced = array_slice($articles, Input::get('page', 1)-1, $count);
			return Paginator::make($sliced, count($articles), 1);
		}
	}

	public static function info($path = '')
	{
		$parts = pathinfo($path);

		// Find just the date
		$date = substr($parts['filename'], 0, 8);

		return array(
				'path'	=> $path,
				'year'	=> $year = substr($date, 0, 4),
				'month' => $month = substr($date, 4, 2),
				'day'	=> $day = substr($date, 6, 2),
				'title' => trim(helpers::unslug(substr($parts['filename'], 8))),
				'link'	=> URL::to() . $year.'/'.$month.'/'.$day.'/'.ltrim(substr($parts['filename'], 8),'-'),
			);
	}

	public static function pages()
	{
		// Get all the articles
		$pages = glob(Config::get('kudos.content_path')."/pages/*.markdown");

		if ($pages)
		{
			// Sort them newest to oldest
			sort($pages);

			// Create the article detail array
			return array_map(function($path)
			{
				// Get path parts
				$parts = pathinfo($path);

				return array(
						'path'	=> $path,
						'title' => trim(helpers::unslug($parts['filename'])),
						'link'	=> URL::to() . 'page/'.$parts['filename'],
					);
			}, $pages);
		}
	}

	//Clean out bad UTF8 characters
	public static function clean($string)
	{
		return iconv('UTF-8', 'UTF-8//IGNORE//TRANSLIT', $string);
	}
}