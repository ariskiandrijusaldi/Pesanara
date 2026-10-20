document.addEventListener('DOMContentLoaded', () => {
    const finishReveal = (el) => {
        el.classList.remove('is-visible');
        el.classList.add('reveal-done');
    };

    const targets = document.querySelectorAll('.reveal');
    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (targets.length > 0) {
        if (!('IntersectionObserver' in window) || reducedMotion) {
            targets.forEach(finishReveal);
        } else {
            const observer = new IntersectionObserver(
                (entries) => {
                    entries.forEach((entry) => {
                        if (!entry.isIntersecting) {
                            return;
                        }

                        entry.target.classList.add('is-visible');
                        window.setTimeout(() => finishReveal(entry.target), 1400);
                        observer.unobserve(entry.target);
                    });
                },
                { threshold: 0.15, rootMargin: '0px 0px -48px 0px' },
            );

            targets.forEach((el) => observer.observe(el));
        }
    }

    const header = document.querySelector('.site-header');

    if (header) {
        const syncHeader = () => header.classList.toggle('is-scrolled', window.scrollY > 12);

        window.addEventListener('scroll', syncHeader, { passive: true });
        syncHeader();
    }
});
