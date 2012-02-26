<?php

return array(

/*
|--------------------------------------------------------------------------
| Site Name
|--------------------------------------------------------------------------
|
| The name of your website. This is used in the title tags throughout the site
|
*/

'site_name' => 'My Name',

/*
|--------------------------------------------------------------------------
| Short "About Me"
|--------------------------------------------------------------------------
|
| This short about paragraph is listed at the top of the homepage and the bottom of
| all other pages. This text can include Markdown formatting and HTML
|
*/

'about_me' => '
__Who am I?__ A dude with a blog.
',			

/*
|--------------------------------------------------------------------------
| Google Analytics ID
|--------------------------------------------------------------------------
|
| The ID for your google analytics account. The javascript snippet will be included on 
| every page using the main layout.
|
*/

'google_analytics_id' => '',

/*
|--------------------------------------------------------------------------
| Content Path
|--------------------------------------------------------------------------
|
| Path to the sites content folder where pages, drafts and published articles are 
| stored. 
|
*/

'content_path' =>  path('base') . 'content',	

/*
|--------------------------------------------------------------------------
| CSS THEME
|--------------------------------------------------------------------------
|
| The css theme file to use for this site
|
*/

'theme' =>  'kudos',

/*
|--------------------------------------------------------------------------
| CACHING
|--------------------------------------------------------------------------
|
| You can turn off caching so it's easier to work on while modifying the system.
| Caching should be enabled while in production.
|
*/

'cache' =>  true,	

/*
|--------------------------------------------------------------------------
| Disqus Shortname
|--------------------------------------------------------------------------
|
| Tells the Disqus service your forum's shortname, which is the unique
| identifier for your website as registered on Disqus.
| If undefined, the Disqus embed script will make a best-guess
| based on the URL of the Disqus embed script.
|
| Usage: Specify your forum shortname as string.
|
*/
    
'disqus_shortname' => '',

/*
|--------------------------------------------------------------------------
| Disqus Developer Mode
|--------------------------------------------------------------------------
|
| Tells the Disqus service that you are testing the system on an
| inaccessible website, e.g. secured staging server or  a local environment.
| If disqus_developer is off or undefined, Disqus' default behavior will
| be to attempt to read the location of your page and validate the URL.
| If unsuccessful, Disqus will not load.
|
| Use this variable to get around this restriction while you
| are testing on an inaccessible website.
| Usage: Specify 1 for on and 0 for off. If undefined, disqus_developer is off.
|
*/
    
'disqus_developer' => 0, 	

);