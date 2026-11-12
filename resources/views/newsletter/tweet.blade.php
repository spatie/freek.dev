<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #e5e7eb;border-radius:12px;margin:16px 0 24px;background:#ffffff;">
    <tr>
        <td style="padding:24px;">
            <p style="margin:0 0 20px;font-size:15px;line-height:1.5;color:#111827;"><strong>{{ $post->shared_tweet_author }}</strong><br><span style="color:#6b7280;font-size:13px;">{{ '@'.$post->sharedTweetHandle() }} · on X</span></p>
            <p style="margin:0 0 20px;font-size:17px;line-height:1.7;color:#111827;">{!! nl2br(e($post->shared_tweet_text)) !!}</p>
            <p style="margin:0;border-top:1px solid #f3f4f6;padding-top:16px;font-size:13px;"><a href="{{ $post->shared_tweet_url }}" style="color:#374151;text-decoration:underline;">Read the original tweet ↗</a></p>
        </td>
    </tr>
</table>
@if(filled($post->text))
<p><strong>My take:</strong> {{ html_entity_decode($post->newsletter_excerpt) }}</p>
@endif
