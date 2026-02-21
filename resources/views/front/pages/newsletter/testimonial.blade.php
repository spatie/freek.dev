<x-app-layout title="Recommend this newsletter">
    <div class="markup mb-8">
        <h1>Recommend this newsletter</h1>
        <p>
            If my newsletter has helped you learn something or stay up to date, I'd appreciate a short recommendation. Tell other developers why it's worth subscribing. Approved recommendations appear on the <a href="{{ route('newsletter.index') }}">newsletter page</a>.
        </p>
    </div>

    <livewire:testimonial-form />
</x-app-layout>
