export default function() {
    Array.from(document.querySelectorAll('[data-lazy]')).forEach(lazy);
}

function lazy(element) {
    const intersectionObserver = new IntersectionObserver(
        (entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const template = element.querySelector('template');
                    const contents = document.importNode(template.content, true);
                    console.log(contents);

                    element.appendChild(contents);

                    observer.disconnect();
                }
            });
        },
        {
            rootMargin: '500px',
        }
    );

    intersectionObserver.observe(element);
}
