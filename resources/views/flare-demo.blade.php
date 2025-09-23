<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flare Demo - Blog Posts</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen">
        <header class="bg-white shadow-sm border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center">
                        <h1 class="text-2xl font-bold text-gray-900">Flare Demo</h1>
                        <span class="ml-3 text-sm text-gray-500 bg-yellow-100 px-2 py-1 rounded">Flare Demo</span>
                    </div>
                    <nav class="flex space-x-8">
                        <a href="#" class="text-gray-700 hover:text-gray-900">Home</a>
                        <a href="#" class="text-gray-700 hover:text-gray-900">About</a>
                        <a href="#" class="text-gray-700 hover:text-gray-900">Contact</a>
                    </nav>
                </div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="mb-8">
                <h2 class="text-3xl font-bold text-gray-900">Latest Blog Posts</h2>
                <p class="mt-2 text-gray-600">Random posts generated for Flare demonstration purposes</p>
            </div>

            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                @foreach($posts as $post)
                <article class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-semibold text-blue-600 uppercase tracking-wide">{{ $post->category }}</span>
                            <span class="text-xs text-gray-500">{{ $post->reading_time }}</span>
                        </div>

                        <h3 class="text-xl font-bold text-gray-900 mb-2 line-clamp-2">{{ $post->title }}</h3>

                        <p class="text-gray-600 mb-4 line-clamp-3">{{ $post->excerpt }}</p>

                        <div class="flex flex-wrap gap-2 mb-4">
                            @foreach($post->tags as $tag)
                            <span class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded">#{{ $tag }}</span>
                            @endforeach
                        </div>

                        <div class="flex items-center justify-between pt-4 border-t">
                            <div class="flex items-center space-x-2">
                                <div class="w-8 h-8 bg-gradient-to-r from-blue-400 to-purple-500 rounded-full"></div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $post->author }}</p>
                                    <p class="text-xs text-gray-500">{{ $post->date }}</p>
                                </div>
                            </div>

                            <div class="flex items-center space-x-3 text-gray-500">
                                <div class="flex items-center space-x-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    <span class="text-xs">{{ number_format($post->views) }}</span>
                                </div>
                                <div class="flex items-center space-x-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                    </svg>
                                    <span class="text-xs">{{ $post->comments }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>

            <div class="mt-12 flex justify-center">
                <nav class="flex items-center space-x-2">
                    <button class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">Previous</button>
                    <button class="px-3 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">1</button>
                    <button class="px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">2</button>
                    <button class="px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">3</button>
                    <span class="px-3 py-2 text-sm text-gray-700">...</span>
                    <button class="px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">8</button>
                    <button class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">Next</button>
                </nav>
            </div>
        </main>

        <footer class="bg-gray-800 text-white mt-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <p class="text-center text-sm">Demo page for Flare presentation - All content is randomly generated</p>
            </div>
        </footer>
    </div>
</body>
</html>