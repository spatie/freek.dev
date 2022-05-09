<x-app-layout title="Advertising">
    <div class="markup">
        <h1>Advertising</h1>
        <p>
            The freek.dev blog and newsletter are read by an audience of PHP developers with a heavy interest in
            Laravel, JavaScript, devops and personal/professional growth. You can get your brand or product in front of
            that audience by running an ad on the blog and/or newsletter.
        </p>
        <p>
            If you are interested in placing an advertisement on the blog or in the newsletter, or have any more
            questions, you can email me at <a href="mailto:freek@spatie.be">freek@spatie.be</a>.
        </p>
        <h2>The blog</h2>
        <p>
            In 2020 the blog had about 930 000 page views. If you want to view some more statistics and learn which pages were
            the most popular read <a href="https://freek.dev/four-years-of-murzebe">this blog post</a>.
        </p>
        <p>
            An advertisement consists of text with two or three sentences that may contain links. I’ll tag on
            ”(sponsored)” so it’s clear to the readers that it’s an advertisement. As the blog should come over as very
            calm, images or logos are not allowed.
        </p>
        <p>
            An ad can be placed on all pages of the blog or one or more specific posts. It will be placed in a white box
            with a smaller font right above the post title. The ad will be displayed for at least a month.
        </p>
        <h2>The newsletter</h2>
        <p>
            The freek.dev newsletter is sent out every month to an audience of PHP developers with a heavy interest
            in Laravel, JavaScript and devops.
        </p>
        <p>
            An advertisement consists of a title, a link that goes behind it, and a short description of one or two
            sentences. I’ll tag on ”(sponsored)” to the title so it’s clear to the readers that it’s an advertisement.
            As the newsletter should come over as very calm, images or logos are not allowed.
        </p>
        <p>
            Currently the subscriber list contains {{ \Spatie\Mailcoach\Domain\Audience\Models\Subscriber::subscribed()->count() }} members. On average open rate is 40%, the click rate 20%.
        <p>
        <p>
            I suspect that a large portion of the readers use software that blocks trackers, so the actual open and
            click rates will probably be a bit higher. Rest assured that, because your ad will be text based, ad
            blockers will not detect or block it.
        </p>
    </div>
</x-app-layout>
