<x-app-layout title="Newsletter">

    <div class="markup mb-8">
        <h1>Newsletter</h1>
        <p>
            Every month I share what I learn from running Spatie, building Oh Dear, and maintaining over 300 open source packages. That means practical tips on Laravel, PHP, and AI that come from shipping real products every day.
        </p>
        <p>
            Expect honest takes, useful tutorials, and the occasional behind-the-scenes look at how we build and maintain things at Spatie. Over 9,500 smart developers already get it in their inbox.
        </p>
        <p>
            Want to know what you're getting yourself into? Take a look at <a href="https://freek-dev.mailcoach.app/archive">the newsletter archive</a>.
        </p>
    </div>
    <div class="mb-8 -mx-4 sm:mx-0 p-4 sm:p-6 md:p-8 bg-yellow-50 border-b-5 border-yellow-500 text-sm text-gray-700">
        @include('front.newsletter.partials.form')
    </div>

    {{-- Testimonials ticker - uncomment when enough submissions are collected
    @php
        $testimonials = \App\Models\NewsletterTestimonial::query()->active()->orderBy('sort_order')->get();
        $third = (int) ceil($testimonials->count() / 3);
        $rows = [
            $testimonials->slice(0, $third)->values(),
            $testimonials->slice($third, $third)->values(),
            $testimonials->slice($third * 2)->values(),
        ];
    @endphp

    @if($testimonials->isNotEmpty())
        <div class="mb-8">
            <h2 class="text-[11px] font-medium uppercase tracking-widest text-gray-400 mb-4">
                What subscribers say
            </h2>
        </div>
        <div class="testimonial-ticker-wrapper relative left-1/2 right-1/2 -ml-[50vw] -mr-[50vw] w-screen space-y-3 mb-8">
            @foreach($rows as $index => $row)
                <div class="testimonial-ticker {{ $index % 2 === 1 ? 'testimonial-ticker--reverse' : '' }}">
                    @for($i = 0; $i < 2; $i++)
                        <div class="testimonial-ticker-track">
                            @foreach($row as $testimonial)
                                <blockquote class="flex-shrink-0 w-64 bg-white border border-gray-100 rounded-lg p-3">
                                    <p class="text-xs text-gray-600 italic leading-relaxed line-clamp-4">
                                        "{{ $testimonial->text }}"
                                    </p>
                                    <footer class="mt-2 flex items-center gap-1.5">
                                        @if($testimonial->avatar_url)
                                            <img src="{{ $testimonial->avatar_url }}" alt="" class="w-5 h-5 rounded-full object-cover" loading="lazy">
                                        @endif
                                        <div class="min-w-0">
                                            @if($testimonial->author_url)
                                                <a href="{{ $testimonial->author_url }}" target="_blank" rel="noopener noreferrer" class="block text-[11px] font-semibold text-gray-700 hover:text-black transition-colors truncate">{{ $testimonial->author_name }}</a>
                                            @else
                                                <span class="block text-[11px] font-semibold text-gray-700 truncate">{{ $testimonial->author_name }}</span>
                                            @endif
                                            @if($testimonial->author_title)
                                                <span class="block text-[10px] text-gray-400 truncate">{{ $testimonial->author_title }}</span>
                                            @endif
                                        </div>
                                    </footer>
                                </blockquote>
                            @endforeach
                        </div>
                    @endfor
                </div>
            @endforeach
        </div>
    @endif
    --}}

    <div class="markup">
        <p>
            Every edition of the newsletter contains one or two sponsored links. Here's <a href="/advertising">some more
                info</a> on that.
        </p>
    </div>
</x-app-layout>
