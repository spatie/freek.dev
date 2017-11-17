@extends('front.layouts.master')

@section('title', 'Advertising')

@section('content')
    <h1 class="pb-4 border-b">Advertising</h1>

    <p class="pt-6">
        The murze.be newsletter is sent out every two weeks to an audience of PHP developers with a heavy interest in
        Laravel, JavaScript and devops. Here you can view a past edition.
    </p>

    <p>
        You can get your brand or product in front of that audience by running an ad in the newsletter. An advertisement
        will run for an entire month (but keep in mind that the newsletter is sent out only once every two weeks).
    </p>

    <p>
        An advertisement consists of a title, a link that goes behind it, and a short description of one or two
        sentences. I’ll tag on ” (sponsored)” to the title so it’s clear to the readers that it’s an advertisement.
        Because the newsletter should come over as very calm, images or logos are not allowed.
    </p>

    <p>
        Currently the subscriber list contains 3500 members. The reported open rate is 55%, the click rate is 25%
    <p>
        I suspect that a large portion of the readers uses software that blocks trackers, so the actual open and click
        rates will probably be a bit higher. Rest assured that, because your ad will be text based, ad blockers will not
        detect or block it.
    </p>

    <p>
        If you are interested in placing an advertisement in the newsletter, or have any more questions, you can email
        me at <a href="mailto:freek@spatie.be">freek@spatie.be</a>.
    </p>
@endsection