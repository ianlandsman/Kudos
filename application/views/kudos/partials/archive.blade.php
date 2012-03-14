@if (isset($articles) and $articles)
<h2 class="home">Articles</h2>
<nav>

	<ul class="clean">
		@foreach ($articles->results AS $article)
			<li>
				<span class="date">{{date('Y-m-d', $article['date'])}}</span> -
				<a href="{{$article['permalink']}}">{{$article['title']}}</a>
			</li>
		@endforeach
	</ul>

	{{$articles->links()}}
</nav>
@endif