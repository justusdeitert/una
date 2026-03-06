/**
 * Lightweight collapse component replacing Bootstrap's collapse.
 * Fires native CustomEvents so existing listeners (fullpage.js) keep working.
 */

const TRANSITION_DURATION = 350;

function dispatch(element: HTMLElement, eventName: string): void {
    element.dispatchEvent(new CustomEvent(eventName, { bubbles: true }));
}

function show(target: HTMLElement): void {
    if (target.classList.contains('show') || target.classList.contains('collapsing')) return;

    dispatch(target, 'show.bs.collapse');

    // Start at height 0 with transition enabled
    target.classList.remove('collapse');
    target.classList.add('collapsing');
    target.style.height = '0';

    // Force reflow so the browser registers height: 0
    target.offsetHeight;

    // Transition to full height
    target.style.height = target.scrollHeight + 'px';

    setTimeout(() => {
        target.classList.remove('collapsing');
        target.classList.add('collapse', 'show');
        target.style.height = '';
        dispatch(target, 'shown.bs.collapse');
    }, TRANSITION_DURATION);
}

function hide(target: HTMLElement): void {
    if (!target.classList.contains('show') || target.classList.contains('collapsing')) return;

    dispatch(target, 'hide.bs.collapse');

    // Set explicit height so transition has a starting value
    target.style.height = target.scrollHeight + 'px';

    // Force reflow
    target.offsetHeight;

    // Transition to height 0
    target.classList.remove('collapse', 'show');
    target.classList.add('collapsing');
    target.style.height = '0';

    setTimeout(() => {
        target.classList.remove('collapsing');
        target.classList.add('collapse');
        target.style.height = '';
        dispatch(target, 'hidden.bs.collapse');
    }, TRANSITION_DURATION);
}

function toggle(target: HTMLElement): void {
    if (target.classList.contains('show')) {
        hide(target);
    } else {
        show(target);
    }
}

// Handle click on [data-toggle="collapse"]
document.addEventListener('click', function (e: MouseEvent) {
    const trigger = (e.target as HTMLElement).closest<HTMLElement>('[data-toggle="collapse"]');
    if (!trigger) return;

    e.preventDefault();

    const targetSelector = trigger.dataset.target || trigger.getAttribute('href');
    if (!targetSelector) return;
    const target = document.querySelector<HTMLElement>(targetSelector);

    if (!target) return;

    // Accordion: close siblings within the same parent
    const parentSelector = target.dataset.parent;
    if (parentSelector) {
        const parent = target.closest(parentSelector);
        if (parent) {
            parent.querySelectorAll<HTMLElement>('.collapse.show').forEach(function (sibling) {
                if (sibling === target) return;
                hide(sibling);
                // Update the trigger's collapsed state
                const id = sibling.id;
                if (id) {
                    document.querySelectorAll<HTMLElement>('[data-target="#' + id + '"], [href="#' + id + '"]').forEach(function (t) {
                        t.classList.add('collapsed');
                        t.setAttribute('aria-expanded', 'false');
                    });
                }
            });
        }
    }

    // Toggle collapsed class on trigger
    const isExpanding = !target.classList.contains('show');
    trigger.classList.toggle('collapsed', !isExpanding);
    trigger.setAttribute('aria-expanded', isExpanding ? 'true' : 'false');

    toggle(target);
});
