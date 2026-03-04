import $ from 'jquery';

/**
 * Lightweight collapse component replacing Bootstrap's collapse.
 * Fires the same jQuery events so existing listeners (fullpage.js) keep working.
 */

const TRANSITION_DURATION = 350;

function show($target) {
    if ($target.hasClass('show') || $target.hasClass('collapsing')) return;

    $target.trigger('show.bs.collapse');

    // Start at height 0 with transition enabled
    $target.removeClass('collapse').addClass('collapsing').css('height', 0);

    // Force reflow so the browser registers height: 0
    $target[0].offsetHeight;

    // Transition to full height
    const scrollHeight = $target[0].scrollHeight;
    $target.css('height', scrollHeight + 'px');

    setTimeout(() => {
        $target.removeClass('collapsing').addClass('collapse show').css('height', '');
        $target.trigger('shown.bs.collapse');
    }, TRANSITION_DURATION);
}

function hide($target) {
    if (!$target.hasClass('show') || $target.hasClass('collapsing')) return;

    $target.trigger('hide.bs.collapse');

    // Set explicit height so transition has a starting value
    $target.css('height', $target[0].scrollHeight + 'px');

    // Force reflow
    $target[0].offsetHeight;

    // Transition to height 0
    $target.removeClass('collapse show').addClass('collapsing');
    $target.css('height', 0);

    setTimeout(() => {
        $target.removeClass('collapsing').addClass('collapse').css('height', '');
        $target.trigger('hidden.bs.collapse');
    }, TRANSITION_DURATION);
}

function toggle($target) {
    if ($target.hasClass('show')) {
        hide($target);
    } else {
        show($target);
    }
}

// Handle click on [data-toggle="collapse"]
$(document).on('click', '[data-toggle="collapse"]', function (e) {
    e.preventDefault();

    const $trigger = $(this);
    const targetSelector = $trigger.data('target') || $trigger.attr('href');
    const $target = $(targetSelector);

    if (!$target.length) return;

    // Accordion: close siblings within the same parent
    const parentSelector = $target.data('parent');
    if (parentSelector) {
        const $parent = $target.closest(parentSelector);
        $parent.find('.collapse.show').not($target).each(function () {
            hide($(this));
            // Update the trigger's collapsed state
            const id = this.id;
            if (id) {
                $('[data-target="#' + id + '"], [href="#' + id + '"]').addClass('collapsed').attr('aria-expanded', 'false');
            }
        });
    }

    // Toggle collapsed class on trigger
    const isExpanding = !$target.hasClass('show');
    $trigger.toggleClass('collapsed', !isExpanding);
    $trigger.attr('aria-expanded', isExpanding ? 'true' : 'false');

    toggle($target);
});
