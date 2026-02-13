import '../css/app.css';
import { Livewire } from '../../vendor/livewire/livewire/dist/livewire.esm';

Livewire.start();

document.addEventListener('livewire:navigated', () => {
    const main = document.querySelector('main');
    if (!main) return;

    const children = Array.from(main.children);

    children.forEach((child, i) => {
        child.animate([
            { opacity: 0, transform: 'translateY(6px)' },
            { opacity: 1, transform: 'translateY(0)' },
        ], {
            duration: 400,
            delay: i * 60,
            easing: 'ease-out',
            fill: 'both',
        });
    });
});

Array.from(document.querySelectorAll('[data-lazy]')).forEach(lazy);

function lazy(element) {
    function observerCallback(entries, observer) {
        entries.forEach((entry) => {
            if (!entry.isIntersecting) {
                return;
            }

            if (element.dataset.lazy === 'twitter') {
                loadTwitter();
                observer.disconnect();
                return;
            }

            const template = element.querySelector('template');
            const contents = document.importNode(template.content, true);
            element.appendChild(contents);
            observer.disconnect();
        });
    }

    const observer = new IntersectionObserver(observerCallback, { rootMargin: '500px' });

    observer.observe(element);
}

let twitterLoaded = false;

function loadTwitter() {
    if (twitterLoaded) {
        return;
    }

    const script = document.createElement('script');
    script.src = 'https://platform.twitter.com/widgets.js';

    document.body.appendChild(script);
}
