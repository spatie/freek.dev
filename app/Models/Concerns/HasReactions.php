<?php

namespace App\Models\Concerns;

use App\Models\Reaction;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasReactions
{
    public function reactions(): MorphMany
    {
        return $this->morphMany(Reaction::class, 'reactable');
    }

    /** @return array<string, array{count: int, commenter_ids: list<int>}> */
    public function groupedReactions(): array
    {
        $grouped = [];

        foreach ($this->reactions as $reaction) {
            if (! isset($grouped[$reaction->emoji])) {
                $grouped[$reaction->emoji] = ['count' => 0, 'commenter_ids' => []];
            }

            $grouped[$reaction->emoji]['count']++;
            $grouped[$reaction->emoji]['commenter_ids'][] = $reaction->commenter_id;
        }

        return $grouped;
    }

    public function toggleReaction(int $commenterId, string $emoji): bool
    {
        $existing = $this->reactions()
            ->where('commenter_id', $commenterId)
            ->where('emoji', $emoji)
            ->first();

        if ($existing) {
            $existing->delete();

            return false;
        }

        $this->reactions()->create([
            'commenter_id' => $commenterId,
            'emoji' => $emoji,
        ]);

        return true;
    }
}
