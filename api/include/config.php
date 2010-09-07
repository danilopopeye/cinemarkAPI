<?php
define('TEMP_DIR', 'tmp/');
define('CACHE_DIR', 'tmp/cache/');

define('EXPIRE_TIME', 3600 * 6);

function __autoload($class) {
    require_once  'include' . DIRECTORY_SEPARATOR . $class . '.php';
}
?>