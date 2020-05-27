<!DOCTYPE html>
<html lang="en" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">

<head></head>

<head>
    <meta charset="utf-8">
    <meta name="x-apple-disable-message-reformatting">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no, date=no, address=no, email=no">
    <!--[if mso]>
    <xml>
        <o:OfficeDocumentSettings>
            <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
    </xml>
    <style>
        td, th, div, p, a, h1, h2, h3, h4, h5, h6 {
            font-family: "Segoe UI", sans-serif;
            mso-line-height-rule: exactly;
        }

        .o-ml-24 {
            margin-left: 24px !important;
        }
    </style>
    <![endif]-->
    <link rel="stylesheet" href="https://cloud.typography.com/6194432/6581412/css/fonts.css">
    <style>
        .hover-bg-red-400:hover {
            background-color: #f98080 !important;
        }

        .hover-bg-green-400:hover {
            background-color: #31c48d !important;
        }

        @media (max-width: 600px) {
            .sm-block {
                display: block !important;
            }

            .sm-text-lg {
                font-size: 18px !important;
            }

            .sm-leading-32 {
                line-height: 32px !important;
            }

            .sm-p-0 {
                padding: 0 !important;
            }

            .sm-px-0 {
                padding-left: 0 !important;
                padding-right: 0 !important;
            }

            .sm-text-center {
                text-align: center !important;
            }
        }
    </style>
</head>

<body style="margin: 0; padding: 0; width: 100%; word-break: break-word; -webkit-font-smoothing: antialiased;">
<div role="article" aria-roledescription="email" aria-label lang="en"
     style="font-family: Whitney SSm A, Whitney SSm B, -apple-system, 'Segoe UI', sans-serif; margin-left: auto; margin-right: auto; max-width: 600px;">
    <div style="padding: 32px 24px;">
        <!--[if mso]>
        <table align="center" cellpadding="0" cellspacing="0" role="presentation"
               style="width: 600px; padding: 24px 32px;">
            <tr>
                <td><![endif]-->
        <table style="width: 100%;" width="100%" cellpadding="0" cellspacing="0" role="presentation">
            <tr>
                <td style="text-align: center;" align="center">
                    <a href="::webViewUrl::" style="font-size: 14px; color: #374151; text-decoration: underline;">View
                        email in browser</a>
                </td>
            </tr>
            <tr>
                <td style="height: 16px;" height="16"></td>
            </tr>
            <tr>
                <td style="font-size: 14px; text-align: center; color: #4b5563;" align="center">
                    This mail was sent using <a href="https://mailcoach.app"
                                                style="color: #374151; text-decoration: underline;">Mailcoach</a>
                </td>
            </tr>
            <tr>
                <td style="height: 16px;" height="16"></td>
            </tr>
            <tr>
                <td>
                    <table align="center" style="margin-left: auto; margin-right: auto;" cellpadding="0" cellspacing="0"
                           role="presentation">
                        <tr>
                            <th class="sm-block sm-px-0" style="padding: 16px 0 16px 16px;">
                                <img src="https://freek.dev/images/murzicoon.png"
                                     style="border: 0; max-width: 100%; line-height: 100%; vertical-align: middle; width: 48px;"
                                     width="48" alt>
                            </th>
                            <th class="sm-p-0 sm-block sm-text-center"
                                style="font-weight: 400; padding: 16px; text-align: left;" align="left">
                                <h1 style="font-size: 20px; line-height: 32px; margin: 0; color: #161e2e; text-transform: uppercase; text-decoration: none;">
                                    freek.dev</h1>
                                <p style="margin: 0; color: #374151;">Hi, welcome to the {{ $editionNumber }} freek.dev
                                    newsletter!</p>
                            </th>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="height: 32px;" height="32"></td>
            </tr>
            <tr>
                <td>
                    <hr style="background-color: #e5e7eb; border-width: 0; height: 1px; margin: 0; color: #e5e7eb;">
                </td>
            </tr>
        </table>
        <ul style="list-style-type: none; margin: 0; padding: 0;">
            @foreach($recentPosts as $post)
                <li style="color: #ffffff;">
                    <h2 style="margin-bottom: 2px;">
                        <a href="{{ $post->promotional_url }}"
                           style="font-size: 18px; color: #161e2e; text-decoration: none;">{{ $post->title }}</a>
                    </h2>
                    <p style="font-size: 16px; margin: 0; color: #252f3f;">{{ $post->newsletter_excerpt }}</p>
                    <hr style="background-color: #e5e7eb; border-width: 0; height: 1px; margin-top: 24px; margin-bottom: 24px; color: #e5e7eb;">
                </li>
            @endforeach
        </ul>
        @if($recentTweets->count())
            <table style="width: 100%;" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                <tr>
                    <td style="background-color: #ebf5ff; padding: 24px;" bgcolor="#ebf5ff">
                        <h3 style="font-size: 20px; margin: 0 0 12px;">Meanwhile on Twitter</h3>
                        <ul align="left" class="o-ml-24"
                            style="font-size: 16px; list-style-type: disc; margin: 0 0 0 20px; padding: 0;">
                            @foreach($recentTweets as $tweet)
                                <li style="margin: 0 0 4px; text-align: left;">
                                    <a href="{{ $tweet->promotional_url }}"
                                       style="color: #252f3f;">{{ $tweet->title }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td style="background-color: #a4cafe; line-height: 4px;" bgcolor="#a4cafe">&zwnj;</td>
                </tr>
                <tr>
                    <td style="height: 32px;" height="32"></td>
                </tr>
            </table>
        @endif
        @if($communityLinks->count())
            <table style="width: 100%;" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                <tr>
                    <td style="background-color: #fff8f1; padding: 24px;" bgcolor="#fff8f1">
                        <h3 style="font-size: 20px; margin: 0 0 12px;">Community Links</h3>
                        <p style="font-size: 16px; margin: 0 0 16px; color: #161e2e;">Did you write or stumbled across a
                            blog post, tutorial or video that might be good to appear in this section? <a
                                href="https://freek.dev/links" style="color: #252f3f;">Submit it here</a>.</p>
                        <ul align="left" class="o-ml-24"
                            style="font-size: 16px; list-style-type: disc; margin: 0 0 0 20px; padding: 0;">
                            @foreach($communityLinks as $link)
                                <li style="margin: 0 0 4px; text-align: left;">
                                    <a href="{{ $link->url }}" style="color: #252f3f;">{{ $link->title }}</a> (submitted
                                    by {{ $link->user->name }})
                                </li>
                                @endif
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td style="background-color: #fdba8c; line-height: 4px;" bgcolor="#fdba8c">&zwnj;</td>
                </tr>
                <tr>
                    <td style="height: 32px;" height="32"></td>
                </tr>
            </table>
        @endif
        <table style="width: 100%;" width="100%" cellpadding="0" cellspacing="0" role="presentation">
            <tr>
                <td style="background-color: #f1f5f9; padding: 24px;" bgcolor="#f1f5f9">
                    <h3 style="font-size: 20px; margin: 0 0 12px;">From the archives</h3>
                    <ul align="left" class="o-ml-24"
                        style="font-size: 16px; list-style-type: disc; margin: 0 0 0 20px; padding: 0;">
                        @foreach($oldPosts as $post)
                            <li style="margin: 0 0 4px; text-align: left;">
                                <a href="{{ $post->promotional_url }}" style="color: #252f3f;">{{ $post->title }}</a>
                            </li>
                            @endif
                    </ul>
                </td>
            </tr>
            <tr>
                <td style="background-color: #cfd8e3; line-height: 4px;" bgcolor="#cfd8e3">&zwnj;</td>
            </tr>
        </table>
        <hr style="background-color: #e5e7eb; border-width: 0; height: 1px; margin-top: 32px; margin-bottom: 32px; color: #e5e7eb;">
        <p style="font-size: 14px; margin: 0; text-align: center; color: #4b5563;">Thanks for reading! Did you like this
            edition of the newsletter?</p>
        <table style="width: 100%;" width="100%" cellpadding="0" cellspacing="0" role="presentation">
            <tr>
                <td style="padding: 32px 0; text-align: center; vertical-align: top; width: 50%;" width="50%"
                    align="center" valign="top">
                    <a href="{{ route('newsletter.like', ['edition' => $editionNumber]) }}"
                       class="sm-text-lg sm-leading-32 hover-bg-green-400"
                       style="background-color: #84e1bc; border-radius: 4px; display: inline-block; font-size: 24px; padding: 12px 24px; text-align: center; color: #ffffff; text-decoration: none;">
                        <!--[if mso]><i style="letter-spacing: 24px; mso-font-width: -100%; mso-text-raise:24px;">&nbsp;</i><![endif]--><span
                            style="mso-text-raise: 12px;">Yes!</span>
                        <!--[if mso]><i style="letter-spacing: 24px; mso-font-width: -100%;">&nbsp;</i><![endif]--></a>
                    <p style="font-size: 14px; margin: 10px 0 0; color: #161e2e;">Really liked it.</p>
                </td>
                <td style="padding: 32px 0; text-align: center; vertical-align: top; width: 50%;" width="50%"
                    align="center" valign="top">
                    <a href="{{ route('newsletter.dislike', ['edition' => $editionNumber]) }}"
                       class="sm-text-lg sm-leading-32 hover-bg-red-400"
                       style="background-color: #f8b4b4; border-radius: 4px; display: inline-block; font-size: 24px; padding: 12px 24px; text-align: center; color: #ffffff; text-decoration: none;">
                        <!--[if mso]><i style="letter-spacing: 24px; mso-font-width: -100%; mso-text-raise:24px;">&nbsp;</i><![endif]--><span
                            style="mso-text-raise: 12px;">Nope...</span>
                        <!--[if mso]><i style="letter-spacing: 24px; mso-font-width: -100%;">&nbsp;</i><![endif]--></a>
                    <p style="font-size: 14px; margin: 10px 0 0; color: #161e2e;">It could be improved.</p>
                </td>
            </tr>
        </table>
        <hr style="background-color: #e5e7eb; border-width: 0; height: 1px; margin: 0 0 32px; color: #e5e7eb;">
        <div style="font-size: 14px; line-height: 20px; color: #4b5563;">
            <p style="margin: 0 0 16px;">
                Advertisement opportunities at
                <a href="{{ url('/advertising') }}" style="color: #4b5563;">freek.dev/advertising</a>.
            </p>
            <p style="margin: 0 0 16px;">
                You are receiving this mail because you've subscribed at
                <a href="{{ config('app.url') }}" style="color: #4b5563;">freek.dev</a>.
                Opt out any time.
                <a href="::unsubscribeUrl::" style="color: #4b5563;">Unsubscribe</a>.
            </p>
            <p style="margin: 0 0 16px;">
                This mail was sent using <a href="https://mailcoach.app" style="color: #4b5563;">Mailcoach</a>.
            </p>
        </div>
        <!--[if mso]></td></tr></table><![endif]-->
    </div>
</div>
</body>

</html>
