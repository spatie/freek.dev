When a request comes in your app will return a response. To create that response, your application has to do some work. Most likely queries will execute. This all takes some time. Wouldn't it be nice if the same request comes in, we can return the response the application has constructed previously?

That's precisely what our package [laravel-responsecache](https://github.com/spatie/laravel-responsecache) can do for you. It can speed up your application by caching the entire response. We recently released [a new major version](https://github.com/spatie/laravel-responsecache/releases/tag/6.0.0) of the package that has a new cool feature. It now can cache pages that still have some small dynamic pieces, such as a csrf token. 

## Basic usage

After you've [installed](https://github.com/spatie/laravel-responsecache#installation) the package (which can be done with a simple `composer require`, all `GET` requests to your app will be cached for a week by default. Of course, you can customize that period. 

In fact, you can customize the entire caching behavior by implementing your own custom cache profile. Such a profile is a class that implements the `CacheProfile` interface. It is responsible for deciding if a request/response should be cached. Here's how that interface looks like:

```php
interface CacheProfile
{
    /*
     * Determine if the response cache middleware should be enabled.
     */
    public function enabled(Request $request): bool;

    /*
     * Determine if the given request should be cached.
     */
    public function shouldCacheRequest(Request $request): bool;

    /*
     * Determine if the given response should be cached.
     */
    public function shouldCacheResponse(Response $response): bool;

    /*
     * Return the time when the cache must be invalidated.
     */
    public function cacheRequestUntil(Request $request): DateTime;

    /**
     * Return a string to differentiate this request from others.
     *
     * For example: if you want a different cache per user you could return the id of
     * the logged in user.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function cacheNameSuffix(Request $request);
}
```

By default the package uses the `CacheAllSuccessfulGetRequests` implementation. It will cache all successful `GET` requests for a week. It will also take care that only text-based responses such as HTML and JSON will be cached.  This is the implementation:

```php
namespace Spatie\ResponseCache\CacheProfiles;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class CacheAllSuccessfulGetRequests extends BaseCacheProfile
{
    public function shouldCacheRequest(Request $request): bool
    {
        if ($request->ajax()) {
            return false;
        }

        if ($this->isRunningInConsole()) {
            return false;
        }

        return $request->isMethod('get');
    }

    public function shouldCacheResponse(Response $response): bool
    {
        if (! $this->hasCacheableResponseCode($response)) {
            return false;
        }

        if (! $this->hasCacheableContentType($response)) {
            return false;
        }

        return true;
    }

    public function hasCacheableResponseCode(Response $response): bool
    {
        if ($response->isSuccessful()) {
            return true;
        }

        if ($response->isRedirection()) {
            return true;
        }

        return false;
    }

    public function hasCacheableContentType(Response $response)
    {
        $contentType = $response->headers->get('Content-Type', '');

        return Str::startsWith($contentType, 'text');
    }
}
```


## Using replacers

Caching the entire response can be problematic for some pages. Imagine your page contains a form. To be able to submit it safely, we need a fresh csrf token. If we were to cache the entire page, it's HTML would contain an old csrf token, that wouldn't be accepted by the server anymore when the form gets submitted.

To solve this problem, the newly released v6 of the package introduces support for replacers. A replacer is a class that can replace a tiny bit of the response before it gets cached. It could, for instance, replace the current csrf token by a placeholder. A replacer can also, when a request comes in for the second time, modify a cached response before it is sent to the browsers. So it can, at that time, replace the placeholder by a fresh csrf token.

Our package ships with a csrf token replacer by default. This is what it looks like.

```php
namespace Spatie\ResponseCache\Replacers;

use Symfony\Component\HttpFoundation\Response;

class CsrfTokenReplacer implements Replacer
{
    protected $replacementString = '<csrf-token-here>';

    public function prepareResponseToCache(Response $response): void
    {
        if (! $response->getContent()) {
            return;
        }

        $response->setContent(str_replace(
            csrf_token(),
            $this->replacementString,
            $response->getContent()
        ));
    }

    public function replaceInCachedResponse(Response $response): void
    {
        if (! $response->getContent()) {
            return;
        }

        $response->setContent(str_replace(
            $this->replacementString,
            csrf_token(),
            $response->getContent()
        ));
    }
}
```

With this in place, you can now even cache pages that contain forms and still allow them to be submitted safely.

## Alternatives

There are some great alternatives to cache responses. 

[Joseph Silber](https://twitter.com/joseph_silber) created [Laravel Page Cache](https://github.com/JosephSilber/page-cache) that can write it's cache to disk and let Nginx read them. Because PHP isn't needed anymore to respond when results are cached, the performance benefits are quite significant. This comes at the cost of a slighter more difficult installation procedure (you'll have to tinker with nginx settings), and you can't have any dynamic content on your page.

Another alternative that is worth checking out is[Barry Vd. Heuvel](https://twitter.com/barryvdh)'s [laravel-httpcache](https://github.com/barryvdh/laravel-httpcache). It allows your app to leverage [HttpCache](https://symfony.com/doc/current/http_cache.html).

Varnish is a reverse proxy that can be used to cache content. There's quite some setup required to make it work, but once you get through that, you'll have a very performant solution. I've used it before myself and have written my experience with it [in this blog post](https://freek.dev/using-varnish-on-a-laravel-forge-provisioned-server). Spoiler: I was able to make a simple server handle 6 000 requests/ second.

## In closing

Our package isn't supposed to sweep performance troubles under the rug. All apps should be optimized so that they'll respond in an acceptable timeframe without using response caching.  Keep in mind that there are [a lot of other aspects that need to be considered](https://developers.google.com/web/fundamentals/performance/why-performance-matters/) when trying to deliver a speedy experience.

Even though there are many good (and faster) alternatives available, I believe [laravel-responsecache](https://github.com/spatie/laravel-responsecache) is the easiest package to get started with response caching. 

If you like the package, do take a look at [this list of packages](https://spatie.be/open-source) our team has released previously.
