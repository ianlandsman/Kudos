<?php defined('DS') or die('No direct script access.'); ?>

<h2 class="home">Site Pages</h2>
<nav>
	<ul>
		@if ($pages)
			@foreach ($pages AS $page)
				<li>
					<a href="{{$page['link']}}">{{$page['title']}}</a>
				</li>
			@endforeach
		@endif	
	</ul>
</nav>