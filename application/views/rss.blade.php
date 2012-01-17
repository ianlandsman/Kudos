<?php defined('APP_PATH') or die('No direct script access.'); ?>

<?php echo '<?xml version="1.0" encoding="utf-8"?>'; ?>
<rss version="2.0">
  <channel>
    <title>{{e(Config::get('kudos.site_name'))}}</title>
    <link>{{URL::to()}}</link>
    <description></description>
    <copyright>{{URL::to()}}</copyright>
    <ttl>30</ttl>

    @foreach ($articles AS $article)
	    <item>
	      <title>{{e($article['title'])}}</title>
	      <description>
	      {{e(helpers::markdown_file($article['path']))}}
	      </description>
	      <link>{{$article['link']}}</link>
	      <guid isPermaLink="true">{{$article['link']}}</guid>
	      <pubDate>{{date(DATE_RSS, mktime(0,0,0,$article['month'],$article['day'],$article['year']))}}</pubDate>
	    </item>
    @endforeach

  </channel>
</rss>