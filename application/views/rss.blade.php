<?php defined('DS') or die('No direct script access.'); ?>
<?php echo '<?xml version="1.0"?>'; ?>
<rss version="2.0">
  <channel>
    <title>{{e(Config::get('kudos.site_name'))}}</title>
    <link>{{URL::to()}}</link>
    <description></description>
    <copyright>{{URL::to()}}</copyright>
    <ttl>30</ttl>

<?php var_dump($articles);exit; ?>
    @if (isset($articles) and is_object($articles))
    @foreach ($articles->results AS $article)
		<item>
			<title>{{htmlspecialchars(Article::title($article))}}</title>
			<description>
			{{htmlspecialchars(Article::content($article))}}
			</description>
			<link>{{Article::url($article)}}</link>
			<guid isPermaLink="true">{{Article::url($article)}}</guid>
			<pubDate>{{date(DATE_RSS, Article::date($article))}}</pubDate>
		</item>
	@endforeach
	@endif

  </channel>
</rss>