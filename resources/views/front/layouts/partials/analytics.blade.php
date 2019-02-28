@if(app()->environment('production'))

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script nonce="{{ csp_nonce() }}" async src="https://www.googletagmanager.com/gtag/js?id=UA-57290920-1"></script>
    <script nonce="{{ csp_nonce() }}" >
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', 'UA-57290920-1');
    </script>

@endif