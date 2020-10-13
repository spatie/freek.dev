@if ($nextPost)
This series is continued in <a href="{{ route('post', $nextPost->slug) }}">{{   lcfirst($nextPost->series_toc_title) }}</a>.
@endif
