(() => {
    const buildCharacters = (element) => {
        const text = element.dataset.text || element.textContent || '';
        const speed = Number.parseInt(element.dataset.speed, 10) || 60;
        const content = element.querySelector('.tap-text-animation__content');

        if (!content) {
            return;
        }

        content.textContent = '';

        Array.from(text).forEach((char, index) => {
            const span = document.createElement('span');
            span.className = 'tap-text-animation__char';
            span.textContent = char === ' ' ? '\u00A0' : char;
            span.style.setProperty('--tap-delay', `${index * speed}ms`);
            content.appendChild(span);
        });
    };

    const init = () => {
        document.querySelectorAll('.tap-text-animation').forEach((element) => {
            if (element.dataset.tapReady === 'true') {
                return;
            }
            element.dataset.tapReady = 'true';
            buildCharacters(element);
        });
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
