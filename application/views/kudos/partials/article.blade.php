@layout(Config::get('kudos.theme').'.layout')


@section('content')

	@if (isset($draft) and $draft)
		<div class="draft">
		This article is a <strong>draft</strong>. Do not link to this URL.
		</div>
	@endif

	<article class="article">

		{{ $body }}

		@if (Config::get('kudos.disqus_shortname'))
			{{View::make('partials.disqus')}}
		@endif
	</article>

	<nav id="article_about_me">
		{{helpers::markdown(Config::get('kudos.about_me'))}}
	</nav>
@endsection