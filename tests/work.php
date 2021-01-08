<?php
require_once '../vendor/autoload.php';

use PhpPmd\Daemon;

if (Daemon::isRunning('tmp/process.pid')) {
    echo "daemon is already running.\n";
} else {
    Daemon::work(array(
        'pid' => 'tmp/process.pid', // required
        'stdin' => '/dev/null',            // defaults to /dev/null
        'stdout' => 'tmp/stdout.txt',  // defaults to /dev/null
        'stderr' => 'tmp/stderr.txt',  // defaults to php://stdout
    ),
        function ($stdin, $stdout, $stderr) { // these parameters are optional
            while (true) {
                // do whatever it is daemons do
                sleep(1); // sleep is good for you
            }
        }
    );
    echo "daemon is now running.\n";
}
