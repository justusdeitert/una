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
    document.addEventListener('DOMContentLoaded', function() {
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
        var currentMenuItem = document.querySelector('.current-menu-item');
        if (currentMenuItem) {
            currentMenuItem.querySelectorAll('a').forEach(function(a) {
                a.style.color = currentRandomColor;
                a.style.borderColor = currentRandomColor;
            });
        }

        var hoverElements = document.querySelectorAll('.page-wrapper a:not(.current-menu-item a), #cookie-notice a, .colored-hover');

        hoverElements.forEach(function(el) {
            el.addEventListener('touchstart', applyHoverColor);
            el.addEventListener('mouseover', applyHoverColor);

            function applyHoverColor() {
                var currentRandomColor = randColors();
                el.style.color = currentRandomColor;
                el.querySelectorAll('h3, i').forEach(function(child) {
                    child.style.color = currentRandomColor;
                });
                el.style.borderColor = currentRandomColor;

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
            }

            el.addEventListener('touchend', removeHoverColor);
            el.addEventListener('mouseout', removeHoverColor);

            function removeHoverColor() {
                el.style.color = '';
                el.querySelectorAll('h3, i').forEach(function(child) {
                    child.style.color = '';
                    child.style.borderColor = '';
                });
                el.style.borderColor = '';
            }
        });

        document.querySelectorAll('.image-wrapper').forEach(function(el) {
            el.addEventListener('touchstart', function() {
                var currentRandomColor = randColors();
                el.classList.add('active');
                var overlay = el.querySelector('.hover-overlay');
                if (overlay) overlay.style.backgroundColor = currentRandomColor;

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

            el.addEventListener('mouseover', function() {
                var currentRandomColor = randColors();
                el.classList.add('active');
                var overlay = el.querySelector('.hover-overlay');
                if (overlay) overlay.style.backgroundColor = currentRandomColor;

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

            el.addEventListener('touchend', function() {
                el.classList.remove('active');
                var overlay = el.querySelector('.hover-overlay');
                if (overlay) overlay.style.backgroundColor = '';
            });

            el.addEventListener('mouseout', function() {
                el.classList.remove('active');
                var overlay = el.querySelector('.hover-overlay');
                if (overlay) overlay.style.backgroundColor = '';
            });
        });
    });
</script>
