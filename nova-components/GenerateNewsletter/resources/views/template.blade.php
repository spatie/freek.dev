<!DOCTYPE html>
<html lang="en" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="utf8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="x-apple-disable-message-reformatting">

    <!--[if mso]>
    <xml>
        <o:officedocumentsettings>
            <o:pixelsperinch>96</o:pixelsperinch>
        </o:officedocumentsettings>
    </xml>
    <style>
        table {
            border-collapse: collapse;
        }

        td, th, div, p, a, h1, h2, h3, h4, h5, h6 {
            font-family: "Segoe UI", sans-serif;
            mso-line-height-rule: exactly;
        }
    </style>
    <![endif]-->
    <style>
        body {
            margin: 0;
            padding: 0;
            width: 100%;
            word-break: break-word;
            -webkit-font-smoothing: antialiased;
        }

        img {
            border: 0;
            line-height: 100%;
            vertical-align: middle;
        }

        a {
            color: #3182ce;
        }

        .bg-gray-200 {
            background-color: #edf2f7 !important;
        }

        .bg-blue-100 {
            background-color: #ebf8ff !important;
        }

        .border-collapse {
            border-collapse: collapse !important;
        }

        .border-gray-200 {
            border-color: #edf2f7 !important;
        }

        .border-gray-400 {
            border-color: #cbd5e0 !important;
        }

        .border-blue-200 {
            border-color: #bee3f8 !important;
        }

        .border-solid {
            border-style: solid !important;
        }

        .border-0 {
            border-width: 0 !important;
        }

        .border-b-4 {
            border-bottom-width: 4px !important;
        }

        .border-t {
            border-top-width: 1px !important;
        }

        .border-b {
            border-bottom-width: 1px !important;
        }

        .font-bold {
            font-weight: 700 !important;
        }

        .leading-16 {
            line-height: 16px !important;
        }

        .leading-24 {
            line-height: 24px !important;
        }

        .list-inside {
            list-style-position: inside !important;
        }

        .m-0 {
            margin: 0 !important;
        }

        .mx-auto {
            margin-left: auto !important;
            margin-right: auto !important;
        }

        .mb-2 {
            margin-bottom: 2px !important;
        }

        .mb-4 {
            margin-bottom: 4px !important;
        }

        .mb-8 {
            margin-bottom: 8px !important;
        }

        .mb-12 {
            margin-bottom: 12px !important;
        }

        .mb-16 {
            margin-bottom: 16px !important;
        }

        .p-0 {
            padding: 0 !important;
        }

        .p-16 {
            padding: 16px !important;
        }

        .p-24 {
            padding: 24px !important;
        }

        .px-4 {
            padding-left: 4px !important;
            padding-right: 4px !important;
        }

        .py-24 {
            padding-top: 24px !important;
            padding-bottom: 24px !important;
        }

        .py-32 {
            padding-top: 32px !important;
            padding-bottom: 32px !important;
        }

        .py-48 {
            padding-top: 48px !important;
            padding-bottom: 48px !important;
        }

        .pl-0 {
            padding-left: 0 !important;
        }

        .pt-24 {
            padding-top: 24px !important;
        }

        .pb-32 {
            padding-bottom: 32px !important;
        }

        .pb-48 {
            padding-bottom: 48px !important;
        }

        .text-center {
            text-align: center !important;
        }

        .text-gray-600 {
            color: #718096 !important;
        }

        .text-gray-700 {
            color: #4a5568 !important;
        }

        .text-gray-800 {
            color: #2d3748 !important;
        }

        .text-gray-900 {
            color: #1a202c !important;
        }

        .text-sm {
            font-size: 14px !important;
        }

        .text-lg {
            font-size: 18px !important;
        }

        .text-xl {
            font-size: 20px !important;
        }

        .underline {
            text-decoration: underline !important;
        }

        .no-underline {
            text-decoration: none !important;
        }

        .w-48 {
            width: 48px !important;
        }

        .w-600 {
            width: 600px !important;
        }

        .w-full {
            width: 100% !important;
        }

        @media screen {
            img {
                max-width: 100%;
            }

            .all-font-sans {
                font-family: Whitney SSm A, Whitney SSm B, -apple-system, "Segoe UI", sans-serif !important;
            }
        }

        @media (max-width: 600px) {
            .sm-w-full {
                width: 100% !important;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cloud.typography.com/6194432/6581412/css/fonts.css">
</head>
<body>
<table class="all-font-sans text-gray-900 leading-24 border-collapse w-600 mx-auto sm-w-full" cellpadding="0"
       cellspacing="0" role="presentation">
    <tr>
        <td class="text-sm text-center py-48">
            <a href="#" class="text-gray-700 underline">View email in browser</a>
        </td>
    </tr>
    <tr>
        <td class="pb-32">
            <table class="mx-auto leading-16" cellpadding="0" cellspacing="0" role="presentation">
                <tr>
                    <td class="p-16 w-48">
                        <a href="https://freek.dev" class="no-underline">
                            <img src="{{ url('images/murzicoon.png') }}" width="48" alt="freek.dev">
                        </a>
                    </td>
                    <td class="p-16 pl-0">
                        <p class="m-0 text-xl font-bold" style="line-height: 30px">
                            FREEK.DEV
                        </p>
                        <p class="m-0 text-gray-700">
                            Hi, welcome to the {{ $editionNumber }} freek.dev newsletter!
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        @foreach($recentPosts as $post)
            <td class="border-solid border-0 border-t border-b border-gray-200">
                <table class="w-full py-24" cellpadding="0" cellspacing="0" role="presentation">
                    <tr>
                        <td>
                            <p class="m-0 mb-2 text-lg font-bold">
                                <a href="{{ $post->promotional_url }}" class="text-gray-900 no-underline">{{ $post->title }}</a>
                            </p>
                            <p class="m-0 text-gray-800">
                                {!! $post->newsletter_excerpt !!}
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
    </tr>
    @endforeach
    <tr>
        <td class="border-solid border-0 border-t border-b border-gray-200">
            <table class="w-full py-24" cellpadding="0" cellspacing="0" role="presentation">
                <tr>
                    <td>
                        <p class="m-0 mb-2 text-lg font-bold">
                            <a href="#" class="text-gray-900 no-underline">Full Stack Europe: a conference for you
                                entire team</a>
                        </p>
                        <p class="m-0 text-gray-800">
                            <span class="px-4 bg-gray-200 text-gray-700">sponsor</span>
                            I'm currently organising Full Stack Europe: a conference in Antwerp, Belgium for developers
                            who want to learn across the stack. You can use this link get your ticket with a nice
                            discount.
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    @if($recentTweets->count())
        <tr>
            <td class="py-32">
                <table class="w-full" cellpadding="0" cellspacing="0" role="presentation">
                    <tr>
                        <td class="bg-blue-100 border-solid border-0 border-b-4 border-blue-200 p-24">
                            <p class="m-0 text-xl mb-12 font-bold">Meanwhile on Twitter</p>
                            <ul class="m-0 p-0 list-inside">
                                @foreach($recentTweets as $tweet)
                                    <li class="m-0"><a href="{{ $tweet->promotional_url }}" class="text-gray-800">{{ $tweet->title }}</a></li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    @endif
    <tr>
        <td class="pb-32">
            <table class="w-full" cellpadding="0" cellspacing="0" role="presentation">
                <tr>
                    <td class="bg-gray-200 border-solid border-0 border-b-4 border-gray-400 p-24">
                        <p class="m-0 text-xl mb-12 font-bold">From the archives</p>
                        <ul class="m-0 p-0 list-inside">
                            @foreach($oldPosts as $post)
                                <li class="m-0 mb-4"><a href="{{ $post->promotional_url }}" class="text-gray-800">{{ $post->title }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td class="text-sm text-gray-600 leading-16 pb-48 pt-24 border-solid border-0 border-t border-gray-200">
            <p class="m-0 mb-16">Advertisement opportunities at <a href=" {{ url('/advertising') }}"
                                                                   class="text-gray-600">freek.dev/advertising</a>.</p>
            <p class="m-0 mb-8">You are receiving this mail because you've subscribed at <a href="{{ config('app.url') }}"
                                                                                            class="text-gray-600">freek.dev</a>.
            </p>
            <p class="m-0">Opt out any time. <a href="#" class="text-gray-600">Unsubscribe</a>.</p>
        </td>
    </tr>
</table>
</body>
</html>
