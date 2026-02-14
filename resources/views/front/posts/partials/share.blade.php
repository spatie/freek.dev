<div class="flex items-center gap-4 text-sm text-gray-500">
    <span class="font-semibold text-gray-700">Share</span>

    <a
        href="https://x.com/intent/tweet?url={{ urlencode($post->url) }}&text={{ urlencode($post->title) }}"
        target="_blank"
        rel="noopener noreferrer"
        class="inline-flex items-center gap-1 text-gray-500 hover:text-black transition-colors"
    >
        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
        <span>Post</span>
    </a>

    <a
        href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode($post->url) }}"
        target="_blank"
        rel="noopener noreferrer"
        class="inline-flex items-center gap-1 text-gray-500 hover:text-black transition-colors"
    >
        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 0 1-2.063-2.065 2.064 2.064 0 1 1 2.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
        <span>LinkedIn</span>
    </a>

    <button
        type="button"
        class="inline-flex items-center gap-1 text-gray-500 hover:text-black transition-colors cursor-pointer"
        onclick="navigator.clipboard.writeText('{{ $post->url }}'); this.querySelector('span').textContent = 'Copied!'; setTimeout(() => this.querySelector('span').textContent = 'Copy link', 2000)"
    >
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><rect x="9" y="9" width="13" height="13" rx="2" ry="2" stroke-linecap="round" stroke-linejoin="round"/><path stroke-linecap="round" stroke-linejoin="round" d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
        <span>Copy link</span>
    </button>

    <span class="text-gray-200">|</span>

    <a
        href="https://x.com/freekmurze"
        target="_blank"
        rel="noopener noreferrer"
        class="inline-flex items-center gap-1 text-gray-400 hover:text-black transition-colors"
    >
        <span>Follow @freekmurze</span>
    </a>
</div>
