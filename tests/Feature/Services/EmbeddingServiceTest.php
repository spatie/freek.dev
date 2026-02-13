<?php

use App\Models\Post;
use App\Services\EmbeddingService;

it('calculates cosine similarity correctly for identical vectors', function () {
    $vector = [1.0, 0.0, 0.0];

    $similarity = EmbeddingService::cosineSimilarity($vector, $vector);

    expect($similarity)->toBeFloat()->toEqualWithDelta(1.0, 0.0001);
});

it('calculates cosine similarity correctly for orthogonal vectors', function () {
    $a = [1.0, 0.0, 0.0];
    $b = [0.0, 1.0, 0.0];

    $similarity = EmbeddingService::cosineSimilarity($a, $b);

    expect($similarity)->toBeFloat()->toEqualWithDelta(0.0, 0.0001);
});

it('calculates cosine similarity correctly for opposite vectors', function () {
    $a = [1.0, 0.0];
    $b = [-1.0, 0.0];

    $similarity = EmbeddingService::cosineSimilarity($a, $b);

    expect($similarity)->toBeFloat()->toEqualWithDelta(-1.0, 0.0001);
});

it('returns zero similarity when a vector has zero magnitude', function () {
    $a = [0.0, 0.0, 0.0];
    $b = [1.0, 2.0, 3.0];

    $similarity = EmbeddingService::cosineSimilarity($a, $b);

    expect($similarity)->toBeFloat()->toEqualWithDelta(0.0, 0.0001);
});

it('calculates cosine similarity for realistic embedding vectors', function () {
    $a = [0.1, 0.2, 0.3, 0.4, 0.5];
    $b = [0.1, 0.2, 0.3, 0.4, 0.5];

    $similarity = EmbeddingService::cosineSimilarity($a, $b);

    expect($similarity)->toBeFloat()->toEqualWithDelta(1.0, 0.0001);
});

it('computes related post ids ordered by similarity', function () {
    $baseEmbedding = array_fill(0, 10, 0.0);
    $baseEmbedding[0] = 1.0;

    $similarEmbedding = array_fill(0, 10, 0.0);
    $similarEmbedding[0] = 0.9;
    $similarEmbedding[1] = 0.1;

    $lessSimilarEmbedding = array_fill(0, 10, 0.0);
    $lessSimilarEmbedding[0] = 0.5;
    $lessSimilarEmbedding[1] = 0.5;

    $differentEmbedding = array_fill(0, 10, 0.0);
    $differentEmbedding[1] = 1.0;

    $mainPost = Post::factory()->create([
        'published' => true,
        'publish_date' => now()->subDays(1),
        'embedding' => $baseEmbedding,
    ]);

    $similarPost = Post::factory()->create([
        'published' => true,
        'publish_date' => now()->subDays(2),
        'embedding' => $similarEmbedding,
    ]);

    $lessSimilarPost = Post::factory()->create([
        'published' => true,
        'publish_date' => now()->subDays(3),
        'embedding' => $lessSimilarEmbedding,
    ]);

    $differentPost = Post::factory()->create([
        'published' => true,
        'publish_date' => now()->subDays(4),
        'embedding' => $differentEmbedding,
    ]);

    $service = new EmbeddingService();
    $relatedIds = $service->computeRelatedPostIds($mainPost, 3);

    expect($relatedIds)->toHaveCount(3);
    expect($relatedIds[0])->toBe($similarPost->id);
    expect($relatedIds[1])->toBe($lessSimilarPost->id);
    expect($relatedIds[2])->toBe($differentPost->id);
});

it('returns empty array when post has no embedding', function () {
    $post = Post::factory()->create([
        'published' => true,
        'publish_date' => now()->subDay(),
        'embedding' => null,
    ]);

    $service = new EmbeddingService();
    $relatedIds = $service->computeRelatedPostIds($post);

    expect($relatedIds)->toBeEmpty();
});

it('retrieves related posts in order via getRelatedPosts', function () {
    $postA = Post::factory()->create([
        'title' => 'Related Post First',
        'published' => true,
        'publish_date' => now()->subDays(2),
    ]);

    $postB = Post::factory()->create([
        'title' => 'Related Post Second',
        'published' => true,
        'publish_date' => now()->subDays(3),
    ]);

    $postC = Post::factory()->create([
        'title' => 'Related Post Third',
        'published' => true,
        'publish_date' => now()->subDays(4),
    ]);

    $mainPost = Post::factory()->create([
        'title' => 'Main Post With Related',
        'published' => true,
        'publish_date' => now()->subDay(),
        'related_post_ids' => [$postB->id, $postA->id, $postC->id],
    ]);

    $relatedPosts = $mainPost->getRelatedPosts();

    expect($relatedPosts)->toHaveCount(3);
    expect($relatedPosts->pluck('id')->toArray())->toBe([$postB->id, $postA->id, $postC->id]);
});

it('returns empty collection when post has no related post ids', function () {
    $post = Post::factory()->create([
        'published' => true,
        'publish_date' => now()->subDay(),
        'related_post_ids' => null,
    ]);

    expect($post->getRelatedPosts())->toBeEmpty();
});

it('respects limit parameter on getRelatedPosts', function () {
    $posts = Post::factory()->count(5)->create([
        'published' => true,
        'publish_date' => now()->subDay(),
    ]);

    $mainPost = Post::factory()->create([
        'published' => true,
        'publish_date' => now()->subDay(),
        'related_post_ids' => $posts->pluck('id')->toArray(),
    ]);

    $relatedPosts = $mainPost->getRelatedPosts(2);

    expect($relatedPosts)->toHaveCount(2);
});

it('excludes unpublished posts from getRelatedPosts', function () {
    $publishedPost = Post::factory()->create([
        'title' => 'Published Related Post',
        'published' => true,
        'publish_date' => now()->subDays(2),
    ]);

    $unpublishedPost = Post::factory()->create([
        'title' => 'Unpublished Related Post',
        'published' => false,
    ]);

    $mainPost = Post::factory()->create([
        'published' => true,
        'publish_date' => now()->subDay(),
        'related_post_ids' => [$publishedPost->id, $unpublishedPost->id],
    ]);

    $relatedPosts = $mainPost->getRelatedPosts();

    expect($relatedPosts)->toHaveCount(1);
    expect($relatedPosts->first()->id)->toBe($publishedPost->id);
});

it('excludes unpublished posts from related post computation', function () {
    $embedding = array_fill(0, 10, 0.0);
    $embedding[0] = 1.0;

    $mainPost = Post::factory()->create([
        'published' => true,
        'publish_date' => now()->subDay(),
        'embedding' => $embedding,
    ]);

    $publishedPost = Post::factory()->create([
        'published' => true,
        'publish_date' => now()->subDays(2),
        'embedding' => $embedding,
    ]);

    $unpublishedPost = Post::factory()->create([
        'published' => false,
        'embedding' => $embedding,
    ]);

    $service = new EmbeddingService();
    $relatedIds = $service->computeRelatedPostIds($mainPost);

    expect($relatedIds)->toContain($publishedPost->id);
    expect($relatedIds)->not->toContain($unpublishedPost->id);
});
