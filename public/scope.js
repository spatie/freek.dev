(function() {
    'use strict';
    var location = window.location
    var document = window.document
    var element = document.currentScript;
    var uuid = 'f23c42d8-2715-4498-b7ca-a3bc544650b4';
    var endpoint = 'https://scope.spatie.be/scope';

    var url = (new URL(location));
    var params = url.searchParams;
    var lastPage;

    function trigger(eventName, options) {
        if (/^localhost$|^127(?:\.[0-9]+){0,2}\.[0-9]+$|^(?:0*\:)*?:?0*1$/.test(location.hostname) || location.protocol === 'file:') return;

        var payload = {}
        payload.site_uuid = uuid;
        payload.url = location.href;
        payload.name = eventName;
        payload.screen_size = window.innerWidth;
        payload.referrer = document.referrer || null;
        payload.utm_campaign = params.get('utm_campaign');
        payload.utm_source = params.get('utm_source');
        payload.utm_medium = params.get('utm_medium');

        if (options && options.meta) {
            payload.meta = JSON.stringify(options.meta)
        }

        var request = new XMLHttpRequest();
        request.open('POST', endpoint, true);
        request.setRequestHeader('Content-Type', 'application/json');
        request.send(JSON.stringify(payload));

        request.onreadystatechange = function() {
            if (request.readyState == 4) {
                options && options.callback && options.callback();
            }
        }
    }

    function page() {
        if (lastPage === location.pathname) return;
        lastPage = location.pathname
        trigger('visit');
    }

    function handleVisibilityChange() {
        if (!lastPage && document.visibilityState === 'visible') {
            page();
        }
    }

    var history = window.history;
    if (history.pushState) {
        var originalPushState = history['pushState'];

        history.pushState = function() {
            originalPushState.apply(this, arguments)
            page();
        }

        window.addEventListener('popstate', page);
    }

    window.scope = trigger;

    if (document.visibilityState === 'prerender') {
        document.addEventListener("visibilitychange", handleVisibilityChange);
    } else {
        page();
    }
})();
