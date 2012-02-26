<?php defined('DS') or die('No direct script access.'); ?>

<article id="small_about_me">
	{{helpers::markdown(Config::get('kudos.about_me'))}}
</article>

@if ($articles)
<h2 class="home">Articles</h2>
<nav>
	<ul class="clean">
		@foreach ($articles AS $article)
			<li>
				<span class="date">{{$article['year']}}-{{$article['month']}}-{{$article['day']}}</span> - 
				<a href="{{$article['link']}}">{{Str::limit(Str::title($article['title']),50)}}</a>
			</li>
		@endforeach
	</ul>
</nav>
@endif

<h2 class="home">Everything Else</h2>
<nav>
	<ul>
		@if ($pages)
			@foreach ($pages AS $page)
				<li>
					<a href="{{$page['link']}}">{{Str::limit($page['title'],50)}}</a>
				</li>
			@endforeach
		@endif
		<li><a href="{{URL::to('/rss')}}">RSS</a></li>
		<li><a href="{{URL::to('/archive')}}">Archive</a></li>		
	</ul>
</nav>