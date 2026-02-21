@php
    $testimonial = \App\Models\NewsletterTestimonial::query()->active()->inRandomOrder()->first();
@endphp

@if($testimonial)
    <blockquote class="mb-4 border-l-3 border-yellow-300 pl-4 py-1">
        <p class="text-sm text-gray-600 italic leading-relaxed">
            "{{ $testimonial->text }}"
        </p>
        <footer class="mt-2 flex items-center gap-2">
            @if($testimonial->avatar_url)
                <img src="{{ $testimonial->avatar_url }}" alt="" class="w-6 h-6 rounded-full object-cover" loading="lazy">
            @endif
            <div class="text-xs text-gray-500">
                @if($testimonial->author_url)
                    <a href="{{ $testimonial->author_url }}" target="_blank" rel="noopener noreferrer" class="font-semibold text-gray-600 hover:text-black transition-colors">{{ $testimonial->author_name }}</a>
                @else
                    <span class="font-semibold text-gray-600">{{ $testimonial->author_name }}</span>
                @endif
                @if($testimonial->author_title)
                    <span class="text-gray-400">&mdash; {{ $testimonial->author_title }}</span>
                @endif
            </div>
        </footer>
    </blockquote>
@endif
