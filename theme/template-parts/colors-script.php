<?php
$link_colors = [];
$colors = get_field('link_colors', 'option');

if ($colors) {
    foreach ($colors as $color) {
        $link_colors[] = $color['color'];
    }
}
?>

<script>
    jQuery(document).ready(function() {
        var colors = <?= json_encode($link_colors); ?>;

        if (window.cookieFunctions.checkCookie()) {
            if (!window.cookieFunctions.getCookie('colors')) {
                window.cookieFunctions.setCookie('colors', JSON.stringify(colors));
            } else {
                if (JSON.parse(window.cookieFunctions.getCookie('colors')).length < 0) {
                    window.cookieFunctions.setCookie('colors', JSON.stringify(colors));
                }
            }
        }

        var randColors;
        if (window.cookieFunctions.checkCookie()) {
            randColors = function() {
                return JSON.parse(window.cookieFunctions.getCookie('colors'))[Math.floor(Math.random() * JSON.parse(
                    window.cookieFunctions.getCookie('colors')).length)];
            }
        } else {
            randColors = function() {
                return colors[Math.floor(Math.random() * colors.length)];
            }
        }

        var currentRandomColor = randColors();
        var currentMenuItem = jQuery('.current-menu-item');
        jQuery(currentMenuItem).children('a').css('color', currentRandomColor);
        jQuery(currentMenuItem).children('a').css('border-color', currentRandomColor);

        var hoverElements = jQuery('.page-wrapper a:not(.current-menu-item a), #cookie-notice a, .colored-hover');

        jQuery(hoverElements).on('touchstart mouseover', function() {
            var currentRandomColor = randColors();
            jQuery(this).css('color', currentRandomColor);
            jQuery(this).children('h3, i').css('color', currentRandomColor);
            jQuery(this).css('border-color', currentRandomColor);

            if (window.cookieFunctions.checkCookie()) {
                var cookieArray = JSON.parse(window.cookieFunctions.getCookie('colors'));

                if (cookieArray.length > 1) {
                    var index = cookieArray.indexOf(currentRandomColor);

                    if (index > -1) {
                        cookieArray.splice(index, 1);
                    }

                    window.cookieFunctions.setCookie('colors', JSON.stringify(cookieArray));
                } else {
                    window.cookieFunctions.setCookie('colors', JSON.stringify(colors));
                }
            }
        });

        jQuery(hoverElements).on('touchend mouseout', function() {
            jQuery(this).css('color', '');
            jQuery(this).children('h3, i').css('color', '');
            jQuery(this).css('border-color', '');
            jQuery(this).children('h3, i').css('border-color', '');
        });

        jQuery('.image-wrapper').on('touchstart mouseover', function() {
            var currentRandomColor = randColors();
            jQuery(this).addClass('active');
            jQuery(this).find('.hover-overlay').css('background-color', currentRandomColor);

            if (window.cookieFunctions.checkCookie()) {
                var cookieArray = JSON.parse(window.cookieFunctions.getCookie('colors'));

                if (cookieArray.length > 1) {
                    var index = cookieArray.indexOf(currentRandomColor);

                    if (index > -1) {
                        cookieArray.splice(index, 1);
                    }

                    window.cookieFunctions.setCookie('colors', JSON.stringify(cookieArray));
                } else {
                    window.cookieFunctions.setCookie('colors', JSON.stringify(colors));
                }
            }
        });

        jQuery('.image-wrapper').on('touchend mouseout', function() {
            jQuery(this).removeClass('active');
            jQuery(this).find('.hover-overlay').css('background-color', '');
        });
    });
</script>
