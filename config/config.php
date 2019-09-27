<?php

use Tracy\Debugger;

define('DB_HOST', 'localhost');
define('DB_NAME', 'blog_projet5');
define('DB_USER', 'root');
define('DB_PASS', 'root');

define('MODE_DEV', true);

define('IMG_DIR', '/img/');
define('IMG_USER_DIR', '../public/img/user/');

if (MODE_DEV) {
    Debugger::enable();
}
