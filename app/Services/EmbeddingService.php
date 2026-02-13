<?php

namespace App\Services;

use App\Models\Post;
use OpenAI\Laravel\Facades\OpenAI;

class EmbeddingService
{
    public function generateEmbedding(Post $post): array
    {
        $input = $post->title . "\n\n" . strip_tags($post->text);
        $input = mb_substr($input, 0, 32000);

        $response = OpenAI::embeddings()->create([
            'model' => 'text-embedding-3-small',
            'input' => $input,
        ]);

        return $response->embeddings[0]->embedding;
    }

    public static function cosineSimilarity(array $a, array $b): float
    {
        $dotProduct = 0.0;
        $magnitudeA = 0.0;
        $magnitudeB = 0.0;

        for ($i = 0, $count = count($a); $i < $count; $i++) {
            $dotProduct += $a[$i] * $b[$i];
            $magnitudeA += $a[$i] * $a[$i];
            $magnitudeB += $b[$i] * $b[$i];
        }

        $magnitudeA = sqrt($magnitudeA);
        $magnitudeB = sqrt($magnitudeB);

        if ($magnitudeA == 0.0 || $magnitudeB == 0.0) {
            return 0.0;
        }

        return $dotProduct / ($magnitudeA * $magnitudeB);
    }

    public function computeRelatedPostIds(Post $post, int $limit = 5): array
    {
        if (empty($post->embedding)) {
            return [];
        }

        $posts = Post::query()
            ->published()
            ->whereNotNull('embedding')
            ->where('id', '!=', $post->id)
            ->get(['id', 'embedding']);

        return $posts
            ->map(fn (Post $other) => [
                'id' => $other->id,
                'similarity' => self::cosineSimilarity($post->embedding, $other->embedding),
            ])
            ->sortByDesc('similarity')
            ->take($limit)
            ->pluck('id')
            ->values()
            ->all();
    }
}
