<html>
    <head>
        <style>{!! file_get_contents(public_path('css/app.css')) !!}</style>
        <link rel="stylesheet" href="https://cloud.typography.com/6194432/6581412/css/fonts.css"/>
        <title>{{ $campaign->subject }}</title>
        <script>
            window.customElements.define('campaign-webview', class NewsletterEmbed extends HTMLElement {
                connectedCallback() {
                    const shadow = this.attachShadow({ mode: 'closed' });
                    shadow.innerHTML = this.getAttribute('contents');
                }
            })
        </script>
    </head>
    <body>
        <header class="w-full mb-4 p-4 sm:p-6 md:px-8 md:py-7 bg-yellow-100 border-b-2 border-yellow-500 text-xs text-gray-700">
            <div class="max-w-lg mx-auto space-y-2">
                <p>
                    Every two weeks I send out a newsletter like this one, containing lots of interesting stuff for the modern
                    PHP
                    developer.
                </p>
                <p>
                    Subscribe to get the next edition in your mailbox.
                </p>
                @include('front.newsletter.partials.form')
            </div>
        </header>

        <campaign-webview contents="{{ $webview }}"></campaign-webview>
    </body>
</html>
