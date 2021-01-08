<?php
require_once '../vendor/autoload.php';

use PhpPmd\Daemon;
if (Daemon::isRunning('process.pid')) {
    echo "daemon is running.\n";
} else {
    echo "daemon is not running.\n";
}
