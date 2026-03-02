<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\StorePostRequest;
use App\Http\Requests\Api\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class PostsController
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = Post::query()->latest('publish_date');

        if ($request->has('published')) {
            $query->where('published', $request->boolean('published'));
        }

        if ($request->has('original_content')) {
            $query->where('original_content', $request->boolean('original_content'));
        }

        if ($request->filled('tag')) {
            $query->withAnyTags([$request->input('tag')]);
        }

        if ($request->filled('search')) {
            $query->where('title', 'like', "%{$request->input('search')}%");
        }

        return PostResource::collection($query->paginate());
    }

    public function show(Post $apiPost): PostResource
    {
        return new PostResource($apiPost);
    }

    public function store(StorePostRequest $request): JsonResponse
    {
        $post = Post::create($request->safe()->except('tags'));

        if ($request->has('tags')) {
            $post->syncTags($request->validated('tags'));
        }

        return (new PostResource($post->refresh()))
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdatePostRequest $request, Post $apiPost): PostResource
    {
        $apiPost->update($request->safe()->except('tags'));

        if ($request->has('tags')) {
            $apiPost->syncTags($request->validated('tags'));
        }

        return new PostResource($apiPost->refresh());
    }

    public function destroy(Post $apiPost): Response
    {
        $apiPost->delete();

        return response()->noContent();
    }
}
