<?php
class Article {

	protected static $articles = array();

	protected static function path($path = '')
	{
		if ( ! is_file($path))
		{
			return null;
		}
		return pathinfo($path);
	}

	public static function date($path = '')
	{
		if ( ! $parts = static::path($path))
		{
			return null;
		}
		return strtotime(substr($parts['filename'], 0, 8));
	}

	public static function title($path = '')
	{
		if ( ! $parts = static::path($path))
		{
			return null;
		}

		return trim(helpers::unslug(substr($parts['filename'], 8)));
	}

	public static function url($path = '')
	{
		if ( ! $parts = static::path($path))
		{
			return null;
		}

		$date = static::date($path);

		return URL::to().date('Y\/m\/d', $date).'/'.ltrim(substr($parts['filename'], 8),'-');
	}

	public static function content($path = '')
	{
		if ( ! $parts = static::path($path))
		{
			return null;
		}

		return helpers::markdown_file($path);
	}

	/**
	 * Parse the article for any header info
	 * @param  string $path
	 * @return array
	 */
	public static function parse($path = '')
	{
		$data = array();

		$segments = explode("\n\n", trim(file_get_contents($path)), 2);

		if (count($segments) > 1)
		{
			$headers = explode("\n", $segments[0]);
			foreach ($headers as $header)
			{
				$type = explode(':', $header);
				$key = strtolower($type[0]);
				// A little hack for urls in header
				if (isset($type[2]))
				{
					unset($type[0]);
					$value = trim(implode(':', $type));
				}
				else
				{
					$value = trim($type[1]);
				}

				switch ($key)
				{
					case 'tags':
						$data['tags'] = explode(',', $value);
					break;
					default:
						$data[$key] = $value;
				}
			}
		}

		$data['title'] = (isset($data['title'])) ? $data['title'] : Str::limit(Str::title(static::title($path)));
		$data['permalink'] = static::url($path);
		$data['date'] = static::date($path);
		$data['body'] = '';
		if (isset($segments[1]))
		{
			$data['body'] = helpers::markdown($segments[1]);
		}
		return $data;
	}

	public static function all()
	{
		if (static::$articles)
		{
			return static::$articles;
		}

		// Get all the articles
		$all = glob(Config::get('kudos.content_path')."/published/*".Config::get('kudos.markdown_extension'));
		// Sort them newest to oldest
		rsort($all);

		$articles = array();

		foreach ($all as $path)
		{
			$articles[] = static::parse($path);
		}
		return static::$articles = $articles;
	}

	public static function get($count = '*')
	{
		if ( ! $articles = static::all())
		{
			return null;
		}

		// Are we limiting? If not let's just give them a set number
		if ($count == '*') $count = 25;

		if (count($articles) < $count)
		{
			return Paginator::make($articles, 0, $count);
		}

		// bug in paging?
		$offset = (Input::get('page', 1)-1)*$count;
		$sliced = array_slice($articles, $offset, $count);
		return Paginator::make($sliced, count($articles), $count);
	}

	public static function search($key = '', $value = '', $limit = 10)
	{
		if ( ! $articles = static::all())
		{
			return null;
		}

		foreach ($articles as $article)
		{
			if (isset($article[$key]) AND strtolower($article[$key]) == strtolower($value))
			{
				$results[] = $article;
			}
		}

		if (count($results) < $limit)
		{
			return Paginator::make($results, count($results), $limit);
		}
		// bug in paging?
		$offset = (Input::get('page', 1)-1)*$limit;
		$sliced = array_slice($results, $offset, $limit);
		return Paginator::make($sliced, count($results), $limit);
	}

	public static function categories()
	{
		if ( ! $articles = static::all())
		{
			return null;
		}

		$categories = array();
		foreach ($articles as $article)
		{
			if (isset($article['category']))
			{
				$categories = array_merge($categories, array($article['category']));
			}
		}
		return $categories;
	}
}