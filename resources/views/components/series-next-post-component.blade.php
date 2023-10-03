@if ($nextPost)
This series is continued in <a href="/{{$post->idSlug()}}">{{   lcfirst($nextPost->series_toc_title) }}</a>.
@endif
