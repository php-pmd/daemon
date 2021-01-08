<?php
require_once '../vendor/autoload.php';

use PhpPmd\Daemon;

if (Daemon::isRunning('tmp/process.pid')) {
    echo "killing running daemon ...\n";
    if (Daemon::kill('tmp/process.pid', false, true)) {
        echo "daemon killed.\n";
    } else {
        echo "failed killing daemon.\n";
    }
} else {
    echo "nothing to kill.\n";
}
