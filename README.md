# Daemon
Daemon based on [Clio](https://github.com/nramenta/clio).

The Daemon class provides helpers for starting and killing daemonized processes.

## Installation
```
composer require php-pmd/daemon
```

PHP 5.4 is required. This library is developed on and is meant to be used on
POSIX systems with the posix, pcntl, and sockets extensions loaded.

### Daemon::isRunning($pid)

Tests if a daemon is currently running or not. Returns true or false:

```php
<?php
use PhpPmd\Daemon;
if (Daemon::isRunning('/path/to/process.pid')) {
    echo "daemon is running.\n";
} else {
    echo "daemon is not running.\n";
}
```

### Daemon::work(array $options, callable $callable)

Daemonize a `$callable` callable object. The `$options` key-value array must
contain `pid` as the path to the PID file:

```php
<?php
use PhpPmd\Daemon;
if (Daemon::isRunning('/path/to/process.pid')) {
    echo "daemon is already running.\n";
} else {
    Daemon::work(array(
            'pid'    => '/path/to/process.pid', // required
            'stdin'  => '/dev/null',            // defaults to /dev/null
            'stdout' => '/path/to/stdout.txt',  // defaults to /dev/null
            'stderr' => '/path/to/stderr.txt',  // defaults to php://stdout
        ),
        function($stdin, $stdout, $stderr) { // these parameters are optional
            while (true) {
                // do whatever it is daemons do
                sleep(1); // sleep is good for you
            }
        }
    );
    echo "daemon is now running.\n";
}
```

The PID file is an ordinary text file with the process ID as its only content.
It will be created by the library automatically if it doesn't exist. It is
highly recommended to put a call to `sleep` to ease the system load.

### Daemon::kill($pid, $force = false, $delete = false)

#### $force

The value of force is `true`, the sig is `SIGKILL`

The value of force is `false`, the sig is `SIGTERM`

#### $delete
Flag to delete PID file after killing

Kill a daemonized process:

```php
<?php
use PhpPmd\Daemon;

if (Daemon::isRunning('/path/to/process.pid')) {
    echo "killing running daemon ...\n";
    if (Daemon::kill('/path/to/process.pid')) {
        echo "daemon killed.\n";
    } else {
        echo "failed killing daemon.\n";
    }
} else {
    echo "nothing to kill.\n";
}
```

If the second parameter is set to `true`, this function will send `SIGKILL` to the process.If it is set to `false`, this function will send `SIGTERM` to the process.

If the third parameter is set to `true`, this function will try to delete the
PID file after successfully sending the process a kill signal. 

## Acknowledgments

The text color and style specifiers are taken entirely from PEAR's Console_Color
class by Stefan Walk. The Daemon class is heavily inspired from Andy Thompson's
blog post on [daemonizing a PHP CLI script on a POSIX system][post].

## License

Clio is released under the [MIT License][MIT].

[Composer]: http://getcomposer.org/
[MIT]: http://en.wikipedia.org/wiki/MIT_License
[post]: http://andytson.com/blog/2010/05/daemonising-a-php-cli-script-on-a-posix-system/
