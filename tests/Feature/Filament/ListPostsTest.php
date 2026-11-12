<?php

use App\Filament\Resources\PostResource\Pages\ListPosts;
use App\Models\Post;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function () {
    $this->actingAs(User::factory()->create(['admin' => true]));
});

it('shows publish dates without seconds and labels unscheduled posts', function () {
    Post::factory()->create([
        'title' => 'Scheduled post',
        'publish_date' => '2026-03-14 09:26:53',
    ]);

    Post::factory()->create([
        'title' => 'Draft post',
        'publish_date' => null,
    ]);

    Livewire::test(ListPosts::class)
        ->assertSee('Mar 14, 2026 09:26')
        ->assertDontSee('09:26:53')
        ->assertSee('Not scheduled');
});
