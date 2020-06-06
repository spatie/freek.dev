@component('mail::message')
Hi,

Your link [{{ $link->title }}]({{ $link->url }}) was approved. You can now view it on [the links page at freek.dev]({{ route('links') }})

To thank you for this link, I'd like to offer you a coupon which grants you a discount when purchasing one of these products of mine:

- [Oh Dear](https://ohdear.app) will notify you whenever your website goes down. Unlike most other services, Oh Dear does not only monitor your homepage, but your entire website. It can notify you when you have broken links or mixed content. It will also monitor the performance of your site, your SSL certificates, provides public status page like [this one](https://status.laravel.com), and much more. The coupon offers you a discount of 5 EUR on your first bill.
- In the [Laravel Package Training video course](https://laravelpackage.training) you'll learn how to create quality framework agnostic PHP and Laravel packages. We'll also source dive a couple of my packages together. I'm sure you will pick up some coding tricks! The coupon grants you a 5% discount.
- [Mailcoach](https://mailcoach.app) is a premium Laravel package that can help sending email campaigns of any size in an affordable way. The coupon grants you a 5% discount.

Here is the coupon code:

{{ config('coupons.submittedLink') }}

Thanks,



Freek
@endcomponent
