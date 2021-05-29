var url = (new URL(document.location));
var params = url.searchParams;

var xhr = new XMLHttpRequest();
xhr.open("POST", 'https://scope.spatie.be/scope', true);
xhr.setRequestHeader('Content-Type', 'application/json');
xhr.send(JSON.stringify({
    url: window.location.href,
    screen_size: window.innerWidth,
    referrer: document.referrer,
    utm_campaign: params.get('utm_campaign'),
    utm_source: params.get('utm_source'),
    utm_medium: params.get('utm_medium'),
    site_uuid: 'f23c42d8-2715-4498-b7ca-a3bc544650b4',
}));
