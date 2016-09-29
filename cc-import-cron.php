<?php
if (php_sapi_name() !='cli') exit;
require_once 'wp-load.php';
cron_func_update();

