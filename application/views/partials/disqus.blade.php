<?php defined('APP_PATH') or die('No direct script access.'); ?>

<section>
	<div id='disqus_thread'></div>
	<script type='text/javascript'>

	var disqus_developer = {{Config::get('kudos.disqus_developer')}};
	var disqus_shortname = '{{Config::get('kudos.disqus_shortname')}}';

	/* * * DON'T EDIT BELOW THIS LINE * * */
	(function() {
	    var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
	    dsq.src = 'http://' + disqus_shortname + '.disqus.com/embed.js';
	    (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
	})();
	</script>
	<noscript>Please enable JavaScript to view the <a href='http://disqus.com/?ref_noscript'>comments powered by Disqus.</a></noscript>
<section>