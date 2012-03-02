@if (isset($articles) and $articles)
<h2 class="home">Articles</h2>
<nav>

	<ul class="clean">
		@foreach ($articles->results AS $article)
			<li>
				<span class="date">{{date('Y-m-d', Article::date($article))}}</span> -
				<a href="{{Article::url($article)}}">{{Str::limit(Str::title(Article::title($article)),50)}}</a>
			</li>
		@endforeach
	</ul>

	{{$articles->links()}}
</nav>
@endif