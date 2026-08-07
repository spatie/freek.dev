@component('mail::message')
Hi,

Your link [{{ $link->title }}]({{ $link->url }}) was approved. You can now view it on [the links page at freek.dev]({{ url('community') }}).

Thanks for sharing it! If you'd like to return the favour, here are the products my team and I build:

- [Oh Dear](https://ohdear.app?utm_source=freek.dev&utm_medium=email&utm_campaign=link-approved) monitors your entire website, not just your homepage. It keeps an eye on uptime, broken links, mixed content, performance and SSL certificates, and gives you a public status page like [this one](https://status.laravel.com).
- [Flare](https://flareapp.io?utm_source=freek.dev&utm_medium=email&utm_campaign=link-approved) is error tracking built for Laravel. It groups your exceptions and shows you exactly what happened. It also does performance monitoring, so you can see which requests, queries, jobs and commands are slowing you down, and it collects your logs so you have all the context around a problem in one place.
- [There There](https://there-there.app?utm_source=freek.dev&utm_medium=email&utm_campaign=link-approved) is an AI-assisted, human-led helpdesk. It puts your own docs and past resolved tickets to work on every email and chat, summarising what's being asked and drafting a reply, so nobody starts from a blank page.
- [Mailcoach](https://mailcoach.app?utm_source=freek.dev&utm_medium=email&utm_campaign=link-approved) sends your newsletters and transactional mails at any scale. You can also set up automations, so your mails go out when someone subscribes, buys something, or hits any other trigger you pick.

We use every one of these ourselves at Spatie, every day. They all started as something we needed for our own work, and we're still their heaviest users, so anything that annoys us gets fixed.

Thanks,



Freek
@endcomponent
