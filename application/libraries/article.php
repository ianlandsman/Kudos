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

}