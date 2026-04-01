(() => {
    const body = document.body;
    const toggle = document.querySelector('[data-mobile-menu-toggle]');
    const menu = document.querySelector('[data-mobile-menu]');
    const panel = menu?.querySelector('.mobile-menu__panel');
    const closeButtons = menu?.querySelectorAll('[data-mobile-menu-close]');
    const menuLinks = menu?.querySelectorAll('a');
    const desktopQuery = window.matchMedia('(min-width: 841px)');

    if (!toggle || !menu || !panel) {
        return;
    }

    const closeMenu = () => {
        body.classList.remove('mobile-menu-open');
        toggle.setAttribute('aria-expanded', 'false');
    };

    const openMenu = () => {
        body.classList.add('mobile-menu-open');
        toggle.setAttribute('aria-expanded', 'true');
    };

    toggle.addEventListener('click', () => {
        if (body.classList.contains('mobile-menu-open')) {
            closeMenu();
            return;
        }

        openMenu();
    });

    closeButtons?.forEach((button) => {
        button.addEventListener('click', closeMenu);
    });

    menuLinks?.forEach((link) => {
        link.addEventListener('click', closeMenu);
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            closeMenu();
        }
    });

    desktopQuery.addEventListener('change', (event) => {
        if (event.matches) {
            closeMenu();
        }
    });
})();
