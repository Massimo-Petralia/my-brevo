<?php

use Jenssegers\Blade\Blade;

function blade() {
    static $blade = null;
    if($blade === null) {
        $basePath = dirname(__DIR__, 3);
        $views = "$basePath/blade/views";
        $cache = "$basePath/blade/cache";
        $blade = new Blade($views, $cache);
    }
    return $blade;
}




