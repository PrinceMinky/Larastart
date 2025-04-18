<?php

// autoloaded by composer.json
// include files within the Helpers directory

foreach (glob(__DIR__.'/*.php') as $file) {
    (basename($file, '.php') !== 'bootstrap') ? require_once $file : null;
}
