[<img src="https://spatie.be/github-ad-image/freek.dev.jpg" width="419px" />](https://spatie.be/github-ad-click/freek.dev)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Blog posts MCP

AI clients manage posts through the Laravel MCP server at `/mcp/posts` using Streamable HTTP. It replaces the removed `/api/posts` REST endpoints. The server advertises its tools, field schemas, and publishing instructions, so a connected AI can discover how to create regular posts, community links, and shared tweets.

### Connection and authentication

Configure your MCP client with the site's base URL followed by `/mcp/posts`, and this HTTP header:

```text
Authorization: Bearer <your-admin-token>
```

Existing Sanctum admin tokens continue to work. Unauthenticated requests receive 401; non-admin users receive 403. Requests are limited to 60 per minute. Clients must support bearer-token headers; OAuth-only clients are not supported.

If you need a new token, create one in a trusted Tinker session and store the result in your client's secret storage:

```php
$user = App\Models\User::query()->where('admin', true)->firstOrFail();
$token = $user->createToken('posts-mcp')->plainTextToken;
```

Keep tokens and draft preview URLs private. To revoke access, delete the corresponding personal access token. The development-only Laravel Boost connection in `.mcp.json` is separate from this post-management server.

### Tools

- `list-posts`: find posts by title (`search`), `published`, `original_content`, or `tag`. Supports `page` and `per_page` (1–50, default 15). Returns `posts`, `current_page`, `last_page`, and `total`.
- `get-post`: retrieve a post by `id`, including Markdown, rendered HTML, tags, saved tweet fields, publication status, and public and preview URLs.
- `create-post`: create a post. Requires `title` and, for regular posts, a Markdown `text` body. New posts default to unpublished, unscheduled drafts with automated tweeting disabled. Returns the saved `post`.
- `update-post`: update a post by `id`. Only supplied fields change. Returns the saved `post`.
- `delete-post`: permanently delete by `id`. Requires `confirm: true` after confirming the intended post. Returns `deleted_post_id`.

Results include MCP `structuredContent` as well as a readable JSON text result. Validation failures return MCP tool errors with `isError: true`; they do not save the invalid post. Check for errors even when the HTTP response is 200. If a create request loses its response, search before retrying to avoid duplicates.

### Sharing a tweet

Ask your connected AI to "create a draft sharing this tweet" and give it the tweet URL. The `create-post` tool accepts these arguments:

```json
{
  "title": "An update from Laravel Idea",
  "shared_tweet_url": "https://x.com/laravel_idea/status/2120086850107048073"
}
```

The server imports the author's display name and tweet text from X. Add `text` for optional Markdown commentary. No `tweet` tag is needed, and `original_content` is always false for shared tweets.

X may truncate long tweets. Review the imported text, or supply both `shared_tweet_author` and `shared_tweet_text` to save a full snapshot without contacting X. These fields also allow saving a tweet when X's importer is unavailable. Never pass provider HTML as tweet text.

Changing `shared_tweet_url` imports a fresh snapshot unless both snapshot fields are supplied. Updating only the comment preserves the saved tweet. Set `text` to `null` to remove commentary. To turn a tweet into a regular post, set `shared_tweet_url` to `null` and provide a non-empty `text` body.

Published tweets appear as native X embeds on the website, with a readable fallback if X cannot load. Feeds and the newsletter's conditional "Noteworthy tweets" section use the saved snapshot without JavaScript. Newsletter inclusion follows the post's publication date within the selected period. These tools do not create or send newsletters or post tweets to X.

### Publishing and other fields

Set `published: true` only to publish immediately. To schedule automatic publication, set `published: false` and a future `publish_date` as an ISO 8601 timestamp with a timezone. Any date on an unpublished post makes it eligible for scheduled publication when due; use `publish_date: null` for an unscheduled draft.

Other supported fields are `original_content`, `external_url`, `tags`, `send_automated_tweet`, `author_twitter_handle`, and `series_slug`. A supplied tag array replaces all tags; `[]` clears them. Omitted fields remain unchanged on update. Use `external_url` for community link sources, not shared tweet URLs. `send_automated_tweet` opts regular posts into promotion when published; shared tweets are never promoted.

## Deployment

The site runs on [Laravel Cloud](https://cloud.laravel.com) and deploys automatically when pushing to `main`.

## Contributing

Please see [CONTRIBUTING](https://github.com/spatie/.github/blob/main/CONTRIBUTING.md) for details.

## Security

If you've found a bug regarding security please mail [security@spatie.be](mailto:security@spatie.be) instead of using the issue tracker.

## Postcardware

You're free to use this code (it's [MIT-licensed](LICENSE.md)). If you use it to set up your own blog we would highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using.

Our address is: Spatie, Kruikstraat 22, 2018 Antwerp, Belgium.

All postcards are published [on our website](https://spatie.be/en/opensource/postcards).

## Credits

- [Freek Van der Herten](https://github.com/freekmurze)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
