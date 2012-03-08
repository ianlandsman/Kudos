<?php defined('DS') or die('No direct script access.'); ?>
<?php echo '<?xml version="1.0" encoding="utf-8"?>'; ?>
<rss version="2.0">
  <channel>
    <title>{{e(Config::get('kudos.site_name'))}}</title>
    <link>{{URL::to()}}</link>
    <description></description>
    <copyright>{{URL::to()}}</copyright>
    <ttl>30</ttl>

    @foreach ($articles->results AS $article)
		<item>
			<title>{{e($article['title'])}}</title>
			<description>
			{{$article['body']}}
			</description>
			<link>{{$article['url']}}</link>
			<guid isPermaLink="true">{{$article['url']}}</guid>
			<pubDate>{{date(DATE_RSS, $article['date'])}}</pubDate>
		</item>
	@endforeach
  </channel>
</rss>