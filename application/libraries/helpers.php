<?php defined('APP_PATH') or die('No direct script access.');


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
		require_once(APP_PATH.'/libraries/markdown.php');

		return markdown($string);
	}		

	public static function restricted_file_get_contents($file)
	{
		if(strpos(realpath($file), Config::get('kudos.content_path')) !== false)
		{
			return file_get_contents($file);
		}
		else
		{
			return '';
		}
	}

	public static function articles($count='*'){
		// Get all the articles
		$articles = glob(Config::get('kudos.content_path')."/published/*.markdown");

		if($articles){
			// Sort them newest to oldest
			rsort($articles);

			// Limit to the number required
			if( $count != '*') $articles = array_slice($articles, 0, $count);

			// Create the article detail array
			return array_map(function($path)
			{
				// Get path parts
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
			}, $articles);
		}
	}

	public static function pages(){
		// Get all the articles
		$pages = glob(Config::get('kudos.content_path')."/pages/*.markdown");

		if($pages){
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
        
        public static function get_disqus_html(){
            
                $discus_developer = Config::get('kudos.disqus_developer');
                $disqus_shortname = Config::get('kudos.disqus_shortname');
                            
                return  "<div id='disqus_thread'></div>
                        <script type='text/javascript'>
                        
                        var disqus_developer = $discus_developer;
                        var disqus_shortname = '$disqus_shortname';

                       /* * * DON'T EDIT BELOW THIS LINE * * */
                        (function() {
                            var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
                            dsq.src = 'http://$disqus_shortname.disqus.com/embed.js';
                            (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
                        })();
                        </script>
                        <noscript>Please enable JavaScript to view the <a href='http://disqus.com/?ref_noscript'>comments powered by Disqus.</a></noscript>
                        <a href='http://disqus.com' class='dsq-brlink'>blog comments powered by <span class='logo-disqus'>Disqus</span></a>";
        }
        
}