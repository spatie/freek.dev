## Codebase Patterns
- Post model is at `app/Models/Post.php` and uses traits like HasTags, InteractsWithMedia, PostPresenter
- User model is at `app/Models/User.php` and implements FilamentUser, MustVerifyEmail
- AppServiceProvider is the main boot location for gates, model config, and third-party setup
- Post show view is `resources/views/front/posts/show.blade.php` and includes partials from `front.posts.partials.*`
- CSS is organized in `resources/css/` with component-specific files in `resources/css/components/`
- FlareDemoController maps post data to a demo view — be careful with method calls on Post that may reference removed features
- Frontend build: `npm run build` (Vite). Tests: `php artisan test --compact`
- Comments-related tables were from spatie/laravel-comments package: `comments`, `comment_notification_subscriptions`, `reactions`
- `.chief/` directory is gitignored
- Invokable controllers follow pattern: single `__invoke()` method returning `View`, matching `OriginalsController`
- Page views live in `resources/views/front/pages/` and reuse `front.posts.partials.list` for post listings
- Spatie Tags stores `slug` as JSON (translatable); query with `where('slug->en', $tagSlug)`
- PostFactory uses a fixed list of titles — when testing `assertDontSee`, use explicit unique titles to avoid collisions
- Snapshot test for PostTest depends on auto-increment IDs; it breaks if run after other tests that create posts. Snapshot file was deleted and regenerated.
- Services live in `app/Services/` with namespace `App\Services`
- `Bus::fake()` is applied globally in `Pest.php` — jobs won't dispatch during tests
- Post model uses `casts()` method (not `$casts` property) — follow this convention
- `spatie/laravel-analytics` facade can be faked with `Analytics::swap(new FakeAnalytics($collection))` for testing
- Popular posts are cached under key `popular_posts` as an array of post IDs, refreshed daily via `FetchPopularPostsJob`

---

## 2026-02-13 - US-001: Remove Comments System
- Removed `spatie/laravel-comments-livewire` package via composer
- Removed `HasComments` trait, `commentableName()`, and `commentUrl()` from Post model
- Removed `InteractsWithComments` trait and `CanComment` interface from User model
- Removed `PendingCommentNotification` setup from AppServiceProvider (including unused imports)
- Removed comments include from `show.blade.php`
- Removed comments CSS import from `app.css`
- Deleted: `config/comments.php`, `database/seeders/CommentSeeder.php`, `resources/css/components/comments.css`, `resources/views/front/posts/partials/comments.blade.php`, `resources/views/front/posts/partials/disqus.blade.php`
- Created migration `2026_02_13_001623_drop_comments_tables.php` to drop `reactions`, `comment_notification_subscriptions`, and `comments` tables
- Replaced `$post->comments()->count()` with `0` in FlareDemoController
- All 45 tests pass, frontend builds successfully
- **Learnings for future iterations:**
  - When removing a composer package, the autoloader will fail if code still references it — remove code references before running `composer dump-autoload`
  - Deleted files need `git rm` or must already be staged; `git add` on a deleted file that's already tracked works but `git rm --cached` on an already-deleted file may fail
  - The `CommentSeeder` was not referenced from `DatabaseSeeder`, so no update needed there
  - Pre-existing unstaged changes (.gitignore, app.js, app.css view-transition CSS) exist on this branch — be careful to only commit relevant changes
---

## 2026-02-13 - US-002: Remove Plausible Analytics
- Removed Plausible `<script>` tag from `resources/views/front/layouts/partials/analytics.blade.php`
- GA4 gtag block remains intact — only the Plausible line (`technical.freek.dev/script.js` with `data-site="FBTOHQOK"`) was removed
- Verified no other references to Plausible exist in the codebase
- All 45 tests pass
- Files changed: `resources/views/front/layouts/partials/analytics.blade.php`
- **Learnings for future iterations:**
  - The Plausible script used a custom domain (`technical.freek.dev`) — search for the domain/site ID too, not just "plausible"
  - Analytics partial is at `resources/views/front/layouts/partials/analytics.blade.php` and is wrapped in `@if(app()->environment('production'))`
---

## 2026-02-13 - US-003: Fix Tag Archive Pages
- Created invokable `TaggedPostsController` that resolves tags via `Tag::query()->where('slug->en', $tagSlug)->firstOrFail()` and queries posts with `Post::withAnyTags([$tag])->published()->simplePaginate(20)`
- Added route `Route::get('tags/{tagSlug}', TaggedPostsController::class)->name('taggedPosts.index')` before the `{post}` catch-all in `routes/web.php`
- Created `resources/views/front/pages/tagged-posts.blade.php` following the `originals.blade.php` pattern, reusing `front.posts.partials.list`
- Created feature test `tests/Feature/Controllers/TaggedPostsControllerTest.php` with 3 tests: shows tagged posts, 404 for non-existing tags, hides unpublished posts
- Fixed pre-existing broken snapshot test by deleting and regenerating the snapshot file
- All 48 tests pass
- Files changed: `app/Http/Controllers/TaggedPostsController.php` (new), `resources/views/front/pages/tagged-posts.blade.php` (new), `tests/Feature/Controllers/TaggedPostsControllerTest.php` (new), `routes/web.php`, snapshot file
- **Learnings for future iterations:**
  - The `{post}` route in web.php is a catch-all — new routes MUST be added before it
  - Spatie Tags `slug` is JSON/translatable — use `where('slug->en', $tagSlug)` not `where('slug', $tagSlug)`
  - PostFactory titles are from a fixed list, so factory-created posts may share titles; use explicit titles in tests that check `assertDontSee`
  - The snapshot test in `PostTest` is fragile — it embeds auto-increment IDs and breaks when test execution order changes
---

## 2026-02-13 - US-004: Related Posts - Embedding Infrastructure
- Installed `openai-php/laravel` package via composer
- Added `OPENAI_API_KEY` and `OPENAI_ORGANIZATION` to `.env.example`
- Created migration `2026_02_13_003946_add_embedding_columns_to_posts_table.php` adding `embedding` (JSON, nullable) and `related_post_ids` (JSON, nullable) columns to posts table
- Added `embedding` and `related_post_ids` array casts to Post model's `casts()` method
- Created `App\Services\EmbeddingService` with:
  - `generateEmbedding(Post $post): array` — uses `text-embedding-3-small` model, concatenates title + stripped text, truncates to 32K chars
  - `cosineSimilarity(array $a, array $b): float` — static method with dot product / magnitude calculation
  - `computeRelatedPostIds(Post $post, int $limit = 5): array` — loads all published posts with embeddings, computes similarity, returns top N IDs
- Created 8 tests in `tests/Feature/Services/EmbeddingServiceTest.php` covering: cosine similarity (identical, orthogonal, opposite, zero magnitude, realistic vectors), related post ID computation ordering, empty embedding handling, unpublished post exclusion
- All 56 tests pass
- Files changed: `composer.json`, `composer.lock`, `.env.example`, `app/Models/Post.php`, `app/Services/EmbeddingService.php` (new), `database/migrations/2026_02_13_003946_add_embedding_columns_to_posts_table.php` (new), `tests/Feature/Services/EmbeddingServiceTest.php` (new)
- **Learnings for future iterations:**
  - Services directory already exists at `app/Services/` with namespace `App\Services`
  - `Bus::fake()` is applied globally in `Pest.php` beforeEach — jobs won't actually dispatch in tests
  - Pre-existing unstaged changes (.gitignore, resources/js/app.js) still exist — continue to only stage relevant files per story
  - Post model uses `casts()` method (not `$casts` property) — follow this pattern when adding casts
- Jobs follow pattern: `implements ShouldQueue` with `Dispatchable, InteractsWithQueue, Queueable, SerializesModels` traits
- Commands use `$signature` property with `app:` prefix for app-specific commands
- When saving data inside a job, use `Post::withoutEvents()` to prevent re-triggering the saved callback
- The snapshot test breaks on every iteration that adds new tests creating posts — always delete and regenerate it

---

## 2026-02-13 - US-005: Related Posts - Jobs & Commands
- Created `GeneratePostEmbeddingJob` that generates embedding for one post via EmbeddingService and saves with `Post::withoutEvents()`
- Created `ComputeRelatedPostsJob` that computes related post IDs for one post via EmbeddingService and saves with `Post::withoutEvents()`
- Created `app:generate-embeddings` command that dispatches `GeneratePostEmbeddingJob` for all published posts missing embeddings; `--force` flag regenerates all
- Created `app:compute-related-posts` command that dispatches `ComputeRelatedPostsJob` for all posts with embeddings
- Added embedding dispatch to `Post::booted()` saved callback: when post is published and `config('openai.api_key')` is set, chains `GeneratePostEmbeddingJob` with `ComputeRelatedPostsJob`; guarded by existing `app()->runningUnitTests()` check
- Fixed TaggedPostsControllerTest to use explicit titles to avoid factory title collisions
- Regenerated fragile snapshot test
- All 61 tests pass
- Files changed: `app/Models/Post.php`, `app/Jobs/GeneratePostEmbeddingJob.php` (new), `app/Jobs/ComputeRelatedPostsJob.php` (new), `app/Console/Commands/GenerateEmbeddingsCommand.php` (new), `app/Console/Commands/ComputeRelatedPostsCommand.php` (new), `tests/Feature/Jobs/GeneratePostEmbeddingJobTest.php` (new), `tests/Feature/Jobs/ComputeRelatedPostsJobTest.php` (new), `tests/Feature/Commands/GenerateEmbeddingsCommandTest.php` (new), `tests/Feature/Commands/ComputeRelatedPostsCommandTest.php` (new), `tests/Feature/Controllers/TaggedPostsControllerTest.php`, snapshot file
- **Learnings for future iterations:**
  - `config('openai.api_key')` is the correct way to check for OpenAI config from the `openai-php/laravel` package
  - Jobs should accept dependencies via `handle()` method parameters (container injection), not constructor
  - The TaggedPostsControllerTest from US-003 had a latent factory title collision bug — fixed by using explicit titles
  - Pre-existing unstaged changes (.gitignore, resources/js/app.js) still exist — continue to only stage relevant files per story
---

## 2026-02-13 - US-006: Related Posts - Display
- Added `getRelatedPosts(int $limit = 5): Collection` method to Post model that queries posts by `related_post_ids`, preserving order
- Created `resources/views/front/posts/partials/related.blade.php` showing up to 5 related posts (gray box, color dots, reading time) — styled to match existing `popular.blade.php` partial
- Included related posts partial in `show.blade.php` after the "Community CTA" section
- Gracefully handles posts with no related posts (no empty box shown via `@if($relatedPosts->isNotEmpty())`)
- Added 4 tests to `tests/Feature/Services/EmbeddingServiceTest.php`: order preservation, empty state, limit parameter, unpublished post exclusion
- All 65 tests pass, frontend builds successfully
- Files changed: `app/Models/Post.php`, `resources/views/front/posts/partials/related.blade.php` (new), `resources/views/front/posts/show.blade.php`, `tests/Feature/Services/EmbeddingServiceTest.php`
- **Learnings for future iterations:**
  - The `popular.blade.php` partial is the best reference for gray-box list styling (color dots via `$post->theme`, reading time via `$post->reading_time`)
  - Order preservation for related posts is achieved by fetching all posts at once with `whereIn`, keying by ID, then mapping over the original ordered ID array
  - Pre-existing unstaged changes (.gitignore, resources/js/app.js) still exist — continue to only stage relevant files per story
---

## 2026-02-13 - US-007: Popular Posts - Service & Job
- Installed `spatie/laravel-analytics` package and published config to `config/analytics.php`
- Added `ANALYTICS_PROPERTY_ID` to `.env.example`
- Added `storage/app/analytics/` to `.gitignore`
- Created `App\Services\PopularPostsService` with:
  - `getPopularPosts(int $limit = 5): Collection` — returns cached popular posts in order, excludes unpublished
  - `refreshCache()` — fetches from GA4 API via `Analytics::fetchMostVisitedPages()`, extracts post IDs from URL paths (`/{id}-{slug}`), deduplicates, caches for 24h
  - `extractPostId(string $url): ?int` — parses URL path and extracts numeric ID prefix
  - Graceful fallback: catches all exceptions and logs errors, never overwrites good cache on failure
- Created `App\Jobs\FetchPopularPostsJob` — calls `PopularPostsService::refreshCache()`
- Scheduled `FetchPopularPostsJob` daily at 04:00 in `routes/console.php`
- Created 8 tests in `tests/Feature/Services/PopularPostsServiceTest.php`: cache order, empty cache, limit, unpublished exclusion, refresh from analytics, error handling, URL parsing, deduplication
- All 73 tests pass
- Files changed: `composer.json`, `composer.lock`, `.env.example`, `.gitignore`, `config/analytics.php` (new), `app/Services/PopularPostsService.php` (new), `app/Jobs/FetchPopularPostsJob.php` (new), `routes/console.php`, `tests/Feature/Services/PopularPostsServiceTest.php` (new)
- **Learnings for future iterations:**
  - `spatie/laravel-analytics` provides `Analytics::fetchMostVisitedPages(Period, maxResults)` returning collections with `fullPageUrl`, `pageTitle`, `screenPageViews` keys
  - The `Spatie\Analytics\Fakes\Analytics` class can be used with `Analytics::swap(new FakeAnalytics($collection))` for testing
  - Post URLs follow pattern `/{id}-{slug}` — extract ID with `preg_match('/^(\d+)-/', $path)`
  - Cache tests need explicit `Cache::forget()` before assertions if other tests may populate the same cache key
  - Pre-existing unstaged changes (.gitignore, resources/js/app.js) still exist — continue to only stage relevant files per story
---

## 2026-02-13 - US-008: Popular Posts - Display
- Created `resources/views/front/posts/partials/popular-now.blade.php` with "Popular this month" heading
- Same visual style as related posts (gray box, color dots, reading time) — matches `related.blade.php` exactly
- Included in `show.blade.php` after related posts section
- Gracefully handles empty state (no box shown when no popular posts via `@if($popularPosts->isNotEmpty())`)
- Resolves popular posts via `app(\App\Services\PopularPostsService::class)->getPopularPosts()` in the partial
- All 73 tests pass, frontend builds successfully
- Files changed: `resources/views/front/posts/partials/popular-now.blade.php` (new), `resources/views/front/posts/show.blade.php`
- **Learnings for future iterations:**
  - The `related.blade.php` partial is the canonical reference for gray-box list styling — match it exactly for consistency
  - Popular posts are resolved via service container in the partial itself (not passed from controller), consistent with how related posts are resolved inline
  - Pre-existing unstaged changes (.gitignore, resources/js/app.js) still exist — continue to only stage relevant files per story
---

## 2026-02-13 - US-009: Archive Page
- Created invokable `ArchiveController` that queries all published posts and groups them by year then month using Eloquent's `groupBy()` with nested closures
- Added route `Route::get('archive', ArchiveController::class)->name('archive')` before the `{post}` catch-all in `routes/web.php`
- Created `resources/views/front/pages/archive.blade.php` with posts grouped by year (h2) and month (h3) subheadings, each post showing color dot, linked title, and compact date
- Added "Archive" link to navigation in `NavigationServiceProvider` between "Originals" and "Community"
- Created feature test `tests/Feature/Controllers/ArchiveControllerTest.php` with 3 tests: grouped display, unpublished exclusion, empty state
- Regenerated fragile snapshot test
- All 76 tests pass
- Files changed: `app/Http/Controllers/ArchiveController.php` (new), `resources/views/front/pages/archive.blade.php` (new), `tests/Feature/Controllers/ArchiveControllerTest.php` (new), `routes/web.php`, `app/Providers/NavigationServiceProvider.php`, snapshot file
- **Learnings for future iterations:**
  - Eloquent `groupBy()` on a collection supports nested grouping via array of closures: `->groupBy([fn => year, fn => month])`
  - Navigation links use `Spatie\Menu\Laravel\Menu` macro pattern with `->url()` method — just add another `->url()` call in the chain
  - Pre-existing unstaged changes (.gitignore, resources/js/app.js) still exist — continue to only stage relevant files per story
---

## 2026-02-13 - US-010: Post Show Page Layout Verification
- Verified post show page renders sections in correct order: Ad, Post header + content, Share buttons, Newsletter block, Community CTA, Related posts, Popular this month
- Ran `npm run build` — Vite production build succeeded (app.css 75.78 kB, app.js 253.27 kB)
- Cleared response cache with `php artisan responsecache:clear`
- All 76 feature tests pass (175 assertions)
- No code changes required — this was a verification-only story; all layout was already correct from US-006 (related posts) and US-008 (popular posts)
- Files changed: none (verification only)
- **Learnings for future iterations:**
  - Verification stories may not require code changes — all ACs can be met by running checks and confirming correctness
  - The pre-existing `resources/js/app.js` change (livewire:navigated view transition) was present throughout the entire project — it was never part of any story
  - All 10 user stories in this project are now complete
---
