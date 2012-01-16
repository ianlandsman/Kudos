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