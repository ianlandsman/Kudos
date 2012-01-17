## Kudos. Markdown based personal publishing.

### Disclaimer

I built this to run [ianlandsman.com](http://ianlandsman.com) over a weekend :) It may not work for you. I'm posting it up in case anyone else may find it useful. It might also be useful to those interested in working with the PHP Laravel framework.

### Installation

Drop the Kudos files into your website folder. Optimally you'll want to make the "public" folder the document root and keep the other folders outside the document root. 

**rename kudos-example.php** to **kudos.php**

Edit kudos.php to set your name and intro. 

Setup a cron to call this command every minute:

    * * * * * php artisan Kudos:publish

If you want to use this with Dropbox you can also set the content folder path to the Dropbox folder you want to use. Note the content folder should match the one that's currently in the root which includes the folders:

* drafts
* pages
* publish
* published

__Note, the storage/* (all), /content/publish, /content/published folders needs to be writable__

### Article/Page format

You should name your articles/pages as URL slugs. So an article named "How to Eat" would be How-To-Eat.markdown

Inside the file use Markdown and/or HTML

### How to publish

You can keep articles you're working on in the content/drafts folder. You can preview it anytime by going in your browser to /drafts/article-slug

When you're ready to publish simply put the article in the content/publish folder. When the publishing task runs it will move it to the published folder and date stamp it.

### Potential issues

* Make sure you upload the .htaccess file in /public to your web server. If not using apache or you dont' want clean URL's then you'll need to add index.php back in for the setting in /application/config/application.php (index setting)
* Make sure the follwoing folders are writable: /storage/* (all), /content/publish, /content/published

### Other Stuff

Kudos caches every URL for 10 minutes. If you need to clear the cache manually you can use:

    php artisan Kudos:clear_cache

Currently Kudos doesn't handle media. I'd recommend just using public dropbox folder as a simple solution.