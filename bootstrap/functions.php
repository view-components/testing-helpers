<?php
namespace ViewComponents\TestingHelpers;

use PDO;
use RuntimeException;

/**
 * @return string
 */
function getProjectPath()
{
    static $projectPath;
    if ($projectPath === null) {
        $currentPackageDirectory = __DIR__ . '/..';
        $outsideProjectDirectory = "$currentPackageDirectory/../../..";
        $autoloadPath = '/vendor/autoload.php';

        if (file_exists($outsideProjectDirectory . $autoloadPath)) {
            $projectPath = realpath($outsideProjectDirectory);
        } elseif (file_exists($currentPackageDirectory . $autoloadPath)) {
            $projectPath = realpath($currentPackageDirectory);
        } else {
            throw new RuntimeException('Failed to locate autoloader generated by composer.');
        }
    }
    return $projectPath;
}

/**
 * @return bool
 */
function isSQLite()
{
    return strpos(getenv('DB_DSN'), 'sqlite:') !== false;
}

/**
 * Returns database connection (PDO).
 *
 * Connection is shared,
 * i.e. this function don't creates new connection each time.
 *
 * Connection is created using following environment variables:
 *  - DB_DSN
 *  - DB_NAME (does not required for SQLite)
 *  - DB_USER
 *  - DB_PASSWORD
 * @return PDO
 */
function dbConnection() {
    static $db;
    if ($db === null) {
        $dsn = getenv('DB_DSN');

        $needToSelectDb = !isSQLite();
        if ($needToSelectDb) {
            $dbName = getenv('DB_NAME');
            $dsn.=";dbname=$dbName";
        }
        $db = new PDO(
            $dsn,
            getenv('DB_USER'),
            getenv('DB_PASSWORD'),
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => 1
            ]
        );
    }
    return $db;
}


function startServer($host, $port, $docRoot, $keepAlive = true)
{
    $pid = null;
    if (!defined('HHVM_VERSION')) {
        $command = "php -S $host:$port -t $docRoot";
    } else {
        $command = "hhvm -m server -p $port -d hhvm.server.source_root=$docRoot";
    }
    echo PHP_EOL, "Starting webserver ($command)... ";

    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        $command = "START /MIN \"testing-web-server\" $command";
        popen($command, 'r');
    } else {
        $command =  "$command & echo $!";
        echo "\r\n\t" . "Executing command: $command";
        $output = array();
        exec($command, $output);
        $pid = (int) $output[0];
        echo "\r\n\tOutput: \r\n\t\t" . join("\r\n\t\t", $output);
    }
    echo "\r\n\t Waiting 0.2 seconds...";
    usleep(200000); //wait 0.2 seconds

    if (!$keepAlive) {
        echo "\r\n\t Registering shutdown function...";
        register_shutdown_function(function() use ($pid){
            stopServer($pid);
        });
    }
    echo PHP_EOL, 'Done.', PHP_EOL;
    return $pid;
}

function stopServer($pid) {
    echo PHP_EOL, 'Stopping web-server... ';
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        exec("TASKKILL /FI \"WINDOWTITLE eq testing-web-server\"");
    } else {
        exec('kill ' . $pid);
    }
    echo 'Done.', PHP_EOL;
}
