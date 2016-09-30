<?php
if (php_sapi_name() !='cli') exit;
require_once 'wp-load.php';
hourly_order_export_func();

