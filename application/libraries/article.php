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
				$value = str_replace(' ', '', $type[1]);
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

		$data['body'] = helpers::markdown($segments[1]);
		return $data;
	}
}