

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/freekdev.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/freek.dev)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Blog Posts API

The site exposes a REST API at `/api/posts` for programmatic blog post management (e.g. by an AI tool). It is protected by Sanctum token authentication and restricted to admin users.

### Authentication

All requests require a Bearer token in the `Authorization` header.

```
Authorization: Bearer <token>
```

To create a token, run this in tinker:

```php
$user = User::where('admin', true)->first();
$token = $user->createToken('ai-tool');
$token->plainTextToken; // save this, it's only shown once
```

### Endpoints

#### List posts

```
GET /api/posts
```

Query parameters (all optional):
- `published` (0 or 1): filter by published status
- `original_content` (0 or 1): filter by original content
- `tag` (string): filter by tag name
- `search` (string): search posts by title

Returns paginated results.

#### Get a post

```
GET /api/posts/{id}
```

#### Create a post

```
POST /api/posts
```

Body (JSON):
- `title` (string, required)
- `text` (string, required, markdown)
- `publish_date` (ISO 8601 date, nullable)
- `published` (boolean, default false)
- `original_content` (boolean, default false)
- `external_url` (URL string, nullable)
- `tags` (array of strings)
- `send_automated_tweet` (boolean, default false)
- `author_twitter_handle` (string, nullable)
- `series_slug` (string, nullable)

Returns 201 with the created post.

#### Update a post

```
PUT /api/posts/{id}
```

Same fields as create, all optional. Only send fields you want to change.

#### Delete a post

```
DELETE /api/posts/{id}
```

Returns 204 No Content.

### Response format

All responses are wrapped in a `data` key:

```json
{
  "data": {
    "id": 1,
    "title": "...",
    "slug": "...",
    "text": "...",
    "html": "...",
    "publish_date": "2026-03-02T14:00:00+00:00",
    "published": true,
    "original_content": false,
    "external_url": null,
    "series_slug": null,
    "author_twitter_handle": null,
    "send_automated_tweet": false,
    "tags": ["laravel", "php"],
    "url": "https://freek.dev/1-post-slug",
    "preview_url": "https://freek.dev/1-post-slug?preview_secret=abc123",
    "created_at": "2026-03-02T12:00:00+00:00",
    "updated_at": "2026-03-02T12:00:00+00:00"
  }
}
```

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
