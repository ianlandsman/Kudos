@layout(Config::get('kudos.theme').'.layout')

@section('content')
	<article id="small_about_me">
		{{helpers::markdown(Config::get('kudos.about_me'))}}
	</article>

	{{View::make(Config::get('kudos.theme').'.partials.archive')->with('articles', $articles)}}

@endsection

@section('else')
	<h2 class="home">Everything Else</h2>
	<nav>
		<ul>
			@if (isset($pages) and $pages)
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
@endsection