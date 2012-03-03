<?php defined('DS') or die('No direct script access.');



class Kudos_task {

	/**
	 * Publish any articles waiting in the publish folder
	 *
	 * @return void
	 */
	public function publish(){
		// Move articles in the publish folder to published.
		// Assign the current date to the filename
		$date = date('Ymd');

		$articles = glob(Config::get('kudos.content_path')."/publish/*".Config::get('kudos.markdown_extension'));

		if($articles){
			foreach ($articles as $draft)
			{
				rename($draft, str_replace('content/publish/', "content/published/{$date}-", $draft));
			}

			// Clear the homepage cache so the articles appear right away
			Cache::forget(md5('/'));
		}
	}

	/**
	 * Expunge cache in cases where we want to complete reset for some reason
	 * obviously only works with file system cache currently as I'm too lazy
	 * to generate each URI. In the future may be useful to add a cache clearing mechanism
	 * to each Laravel cache driver.
	 *
	 * @return void
	 */
	public function clear_cache(){
		foreach (glob(STORAGE_PATH . "/cache/*") as $cache)
		{
			@unlink($cache);
		}
	}

	/**
	 * Run the installation process which creates the database, sets up Laravel
	 * migrations and does the initial migration.
	 *
	 * Current we don't use the DB for Kudos but we may in the future
	 *
	 * @return void
	 */
	public function install(){

		// Don't allow an installation to proceed without the content path set
		if(Config::get('kudos.content_path') == '')
		{
			die('content_path must be set in config.php' . PHP_EOL);
		}

		$path = DATABASE_PATH.Config::get('database.connections.sqlite.database').'.sqlite';

		// Install the sqlite DB
		if( ! file_exists($path) && ! touch($path))
		{
			die('Database path not writable: ' . $path . PHP_EOL);
		}
		else
		{
			echo system('php artisan migrate:install') . PHP_EOL;
			echo system('php artisan migrate:run') . PHP_EOL;
		}
	}

	/**
	 * Run the upgrade migrations
	 *
	 * @return void
	 */
	public function upgrade(){
		echo system('php artisan migrate:run') . PHP_EOL;
	}

}