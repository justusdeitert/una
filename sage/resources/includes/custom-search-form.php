<?php

namespace App;

use App\Controllers\Util\JsonManifest;
use App\Controllers\Util\Blade;
use App\Controllers\Util\BladeProvider;

// Custom Default wp Search form
add_filter('get_search_form', function () {
    $form = '';
    echo template('partials.search-form');
    return $form;
});
