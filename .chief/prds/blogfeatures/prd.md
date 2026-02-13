# Blog Content Discovery & Cleanup

## Overview
The blog's old content gets buried in a chronological feed with no discovery features. This project removes dead code (comments, Plausible analytics), fixes broken tag navigation, and adds content discovery through related posts (OpenAI embeddings), popular posts (Google Analytics API), and a year/month archive page.

Production runs MySQL 8.0.27, so embeddings are stored as JSON columns.

## User Stories

### US-001: Remove Comments System
**Priority:** 1
**Description:** As a developer, I want to remove the unused comments system so that the codebase is cleaner and has fewer dependencies.

**Acceptance Criteria:**
- [ ] `spatie/laravel-comments-livewire` package is removed via composer
- [ ] `HasComments` trait, `commentableName()`, and `commentUrl()` removed from `Post` model
- [ ] `InteractsWithComments` trait and `CanComment` interface removed from `User` model
- [ ] `PendingCommentNotification` block removed from `AppServiceProvider`
- [ ] Comments include removed from `show.blade.php`
- [ ] Comments CSS import removed from `app.css` if present
- [ ] Config, seeder, CSS, and partial view files deleted (`config/comments.php`, `database/seeders/CommentSeeder.php`, `resources/css/components/comments.css`, `resources/views/front/posts/partials/comments.blade.php`, `resources/views/front/posts/partials/disqus.blade.php`)
- [ ] Migration created to drop `comments`, `comment_notification_subscriptions`, and `reactions` tables
- [ ] `FlareDemoController` cleaned up if it references `$post->comments()`
- [ ] Post pages render without error after removal

### US-002: Remove Plausible Analytics
**Priority:** 1
**Description:** As a developer, I want to remove the Plausible analytics script so that only GA4 is used for tracking.

**Acceptance Criteria:**
- [ ] Plausible `<script>` tag removed from `resources/views/front/layouts/partials/analytics.blade.php`
- [ ] GA4 gtag block remains intact
- [ ] Production only loads the GA4 script

### US-003: Fix Tag Archive Pages
**Priority:** 2
**Description:** As a reader, I want to click a tag on a blog post and see all posts with that tag so that I can discover related content by topic.

**Acceptance Criteria:**
- [ ] Invokable `TaggedPostsController` created, accepting a `$tagSlug` parameter
- [ ] Tag resolved via `Tag::query()->where('slug->en', $tagSlug)->firstOrFail()` (Spatie Tags stores slug as JSON)
- [ ] Posts queried with `Post::withAnyTags([$tag])->published()->simplePaginate(20)`
- [ ] Route added in `routes/web.php` BEFORE the `{post}` catch-all: `Route::get('tags/{tagSlug}', ...)->name('taggedPosts.index')`
- [ ] View `front.pages.tagged-posts` created following pattern of `originals.blade.php`, reusing `front.posts.partials.list`
- [ ] `/tags/laravel` and `/tags/php` show correctly tagged posts
- [ ] Feature test in `tests/Feature/Controllers/TaggedPostsControllerTest.php`

### US-004: Related Posts - Embedding Infrastructure
**Priority:** 3
**Description:** As a developer, I want to generate and store OpenAI embeddings for blog posts so that related posts can be computed from them.

**Acceptance Criteria:**
- [ ] `openai-php/laravel` package installed
- [ ] `OPENAI_API_KEY` and `OPENAI_ORGANIZATION` added to `.env.example`
- [ ] Migration adds `embedding` (JSON, nullable) and `related_post_ids` (JSON, nullable) columns to posts table
- [ ] Post model casts `embedding` and `related_post_ids` as arrays
- [ ] `EmbeddingService` created with `generateEmbedding(Post $post): array` using `text-embedding-3-small` model with `$post->title . "\n\n" . strip_tags($post->text)` (truncated to 32K chars)
- [ ] `EmbeddingService::cosineSimilarity(array $a, array $b): float` implemented with dot product / magnitude calculation
- [ ] `EmbeddingService::computeRelatedPostIds(Post $post, int $limit = 5): array` loads all published post embeddings, computes similarity, returns top N IDs
- [ ] Unit test for cosine similarity in `tests/Feature/Services/EmbeddingServiceTest.php`

### US-005: Related Posts - Jobs & Commands
**Priority:** 4
**Description:** As a developer, I want artisan commands and queued jobs to generate embeddings and compute related posts so that the system can be populated initially and kept up to date.

**Acceptance Criteria:**
- [ ] `GeneratePostEmbeddingJob` generates embedding for one post, saves with `Post::withoutEvents()`
- [ ] `ComputeRelatedPostsJob` computes related post IDs for one post, saves with `Post::withoutEvents()`
- [ ] `app:generate-embeddings` command dispatches `GeneratePostEmbeddingJob` for all published posts missing embeddings; `--force` flag regenerates all
- [ ] `app:compute-related-posts` command dispatches `ComputeRelatedPostsJob` for all posts with embeddings
- [ ] On post save (in `Post::booted()` saved callback), `GeneratePostEmbeddingJob` chained with `ComputeRelatedPostsJob` is dispatched when post is published and OpenAI key is configured, guarded by `app()->runningUnitTests()`

### US-006: Related Posts - Display
**Priority:** 5
**Description:** As a reader, I want to see related posts at the bottom of a blog post so that I can discover similar content.

**Acceptance Criteria:**
- [ ] `Post::getRelatedPosts(int $limit = 5)` method queries posts by `related_post_ids`, preserving order
- [ ] `resources/views/front/posts/partials/related.blade.php` created showing up to 5 related posts (gray box, color dots, reading time)
- [ ] Related posts partial included in `show.blade.php` after the "Community CTA" section
- [ ] Gracefully handles posts with no related posts (no empty box shown)
- [ ] Test for related posts retrieval in `tests/Feature/Services/EmbeddingServiceTest.php`

### US-007: Popular Posts - Service & Job
**Priority:** 6
**Description:** As a developer, I want to fetch popular posts from Google Analytics so that readers can see what's trending.

**Acceptance Criteria:**
- [ ] `spatie/laravel-analytics` package installed and config published
- [ ] `.env.example` updated with `ANALYTICS_PROPERTY_ID`
- [ ] `storage/app/analytics/` added to `.gitignore`
- [ ] `PopularPostsService` created with `getPopularPosts(int $limit = 5): Collection` (returns cached results) and `refreshCache()` (fetches from GA4 API, maps URLs to Post models via ID extraction from path `/123-slug`, caches 24h)
- [ ] Graceful fallback: returns empty collection on API errors
- [ ] `FetchPopularPostsJob` calls `PopularPostsService::refreshCache()`, scheduled daily at 04:00 in `routes/console.php`
- [ ] Test in `tests/Feature/Services/PopularPostsServiceTest.php`

### US-008: Popular Posts - Display
**Priority:** 7
**Description:** As a reader, I want to see popular posts on blog post pages so that I can discover trending content.

**Acceptance Criteria:**
- [ ] `resources/views/front/posts/partials/popular-now.blade.php` created with "Popular this month" heading
- [ ] Same visual style as related posts (gray box, color dots)
- [ ] Included in `show.blade.php` after related posts section
- [ ] Gracefully handles empty state (no box shown when no popular posts)

### US-009: Archive Page
**Priority:** 8
**Description:** As a reader, I want to browse all blog posts organized by year and month so that I can explore the full history of the blog.

**Acceptance Criteria:**
- [ ] Invokable `ArchiveController` created, querying all published posts grouped by year then month
- [ ] Route added in `routes/web.php` before `{post}` catch-all: `Route::get('archive', ...)->name('archive')`
- [ ] `resources/views/front/pages/archive.blade.php` created with posts grouped by year with month subheadings
- [ ] Each post shows: color dot, linked title, date (compact list style, not full post cards)
- [ ] "Archive" link added to navigation in `NavigationServiceProvider`
- [ ] Feature test in `tests/Feature/Controllers/ArchiveControllerTest.php`

### US-010: Post Show Page Layout Verification
**Priority:** 9
**Description:** As a developer, I want to verify the final layout of the post show page matches the intended order after all changes are complete.

**Acceptance Criteria:**
- [ ] Post show page renders sections in order: Ad, Post header + content, Share buttons, Newsletter block, Community CTA, Related posts, Popular this month
- [ ] Response cache cleared with `php artisan responsecache:clear`
- [ ] `npm run build` run after CSS changes
- [ ] All feature tests pass with `php artisan test --compact`
