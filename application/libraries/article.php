<?php
class Article {

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
				$value = trim($type[1]);
				switch (strtolower($type[0]))
				{
					case 'tags':
						$data['tags'] = explode(',', $value);
					break;
					default:
						$key = strtolower($type[0]);
						$data[$key] = $value;
				}
			}
		}

		$data['title'] = (isset($data['title'])) ? $data['title'] : Str::limit(Str::title(static::title($path)));
		$data['url'] = static::url($path);
		$data['date'] = static::date($path);
		$data['body'] = helpers::markdown($segments[1]);
		return $data;
	}

	public static function get($count = '*')
	{
		// Get all the articles
		$articles = glob(Config::get('kudos.content_path')."/published/*".Config::get('kudos.markdown_extension'));

		if ($articles)
		{
			// Sort them newest to oldest
			rsort($articles);

			// Are we limiting? If not let's just give them a set number
			if ($count == '*') $count = 25;

			// bug in paging?
			$sliced = array_slice($articles, Input::get('page', 1)-1, $count);
			foreach ($sliced as $path)
			{
				$article[] = static::parse($path);
			}
			return Paginator::make($article, count($articles), $count);
		}
	}
}