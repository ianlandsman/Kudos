<?php defined('DS') or die('No direct script access.'); ?>

<!doctype html>
<head>
	<meta charset="utf-8">
	<title>{{$title}}{{Config::get('kudos.site_name')}}</title>

	<!-- Google Fonts -->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700' rel='stylesheet' type='text/css'>

	<!-- Kudos stylesheets -->
	<link rel="stylesheet" href="{{URL::to_asset('css/html5reset.css')}}">
	<link rel="stylesheet" href="{{URL::to_asset('css/'.Config::get('kudos.theme').'.css')}}">

	<!-- RSS -->
	<link rel="alternate" type="application/rss+xml" title="RSS" href="{{URL::to('/rss')}}" />
</head>

<body>


	<header>
		
		<a href="{{URL::to()}}">{{Config::get('kudos.site_name')}}</a>
	
	</header>
	
		
	{{$body}}
	
	
	<footer>
		
		<p>
			<small>&copy; Copyright {{date('Y')}}. All Rights Reserved.</small> 
			<small>Powered by <a href="https://github.com/ianlandsman/Kudos">Kudos</a></small>
		</p>
		
	</footer>


<!-- jQuery just in case -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>

@if (Config::get('kudos.google_analytics_id')) 
	<script>

	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', '{{Config::get('kudos.google_analytics_id')}}']);
	  _gaq.push(['_trackPageview']);

	  (function() {
	    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();

	</script>
@endif
  
</body>
</html>